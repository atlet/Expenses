<?php

declare(strict_types=1);

/** One-time, repeatable import of the office Ledger journal into the local SQLite database. */

const DEFAULT_LEDGER = '/home/atlet/Nextcloud/Podjetje/stroski-pisarne.ledger';

$arguments = array_slice($argv, 1);
$dryRun = in_array('--dry-run', $arguments, true);
$paths = array_values(array_filter($arguments, fn($argument) => $argument !== '--dry-run'));
if (count($paths) > 1 || ($paths !== [] && str_starts_with($paths[0], '--'))) {
    fwrite(STDERR, "Usage: php bin/import-ledger.php [source] [--dry-run]\n");
    exit(1);
}
$source = $paths[0] ?? DEFAULT_LEDGER;
$database = dirname(__DIR__) . '/db/app.sqlite';
if (!is_file($source) || !is_readable($source) || !is_file($database)) {
    fwrite(STDERR, "Ledger source or application database is unavailable.\n");
    exit(1);
}

function fail(string $message): never
{
    throw new RuntimeException($message);
}

function isoDate(string $date): string
{
    $value = DateTimeImmutable::createFromFormat('!Y/m/d', $date);
    if (!$value || $value->format('Y/m/d') !== $date) {
        fail("Invalid date: {$date}");
    }
    return $value->format('Y-m-d');
}

function cents(string $amount): int
{
    if (!preg_match('/^(\d+)(?:\.(\d{1,2}))?$/', $amount, $match)) {
        fail("Invalid EUR amount: {$amount}");
    }
    return (int)$match[1] * 100 + (int)str_pad($match[2] ?? '', 2, '0');
}

function money(int $cents): string
{
    return sprintf('%d.%02d', intdiv($cents, 100), $cents % 100);
}

try {
    $content = file_get_contents($source);
    if ($content === false) {
        fail('Could not read Ledger source.');
    }
    $transactions = [];
    $unknown = [];
    foreach (preg_split('/\R\s*\R/u', $content) as $block) {
        $lines = preg_split('/\R/u', trim($block));
        $headerIndex = null;
        foreach ($lines as $index => $line) {
            if (preg_match('/^\d{4}\/\d{2}\/\d{2}/', $line)) {
                $headerIndex = $index;
                break;
            }
        }
        if ($headerIndex === null) {
            continue;
        }
        $header = $lines[$headerIndex];
        if (!preg_match('/^(\d{4}\/\d{2}\/\d{2})(?:=(\d{4}\/\d{2}\/\d{2}))?\s+(\*)?\s*(.+)$/u', $header, $match)) {
            $unknown[] = $header;
            continue;
        }
        $date = isoDate($match[1]);
        $secondaryDate = isset($match[2]) && $match[2] !== '' ? isoDate($match[2]) : null;
        $cleared = ($match[3] ?? '') === '*';
        $title = trim($match[4]);
        $postings = [];
        $shareTotal = null;
        $shares = [];
        $comments = [];
        foreach (array_slice($lines, 0, $headerIndex) as $line) {
            if (preg_match('/^\s*;(.*)$/u', $line, $comment)) {
                $comments[] = trim($comment[1]);
            }
        }
        foreach (array_slice($lines, $headerIndex + 1) as $line) {
            if (preg_match('/^\s*;(.*)$/u', $line, $comment)) {
                $comments[] = trim($comment[1]);
                continue;
            }
            if (trim($line) === '') {
                continue;
            }
            if (preg_match('/^\s+\[Share(?::Person:([^\s\]]+))?\]\s+(-?\d+(?:\.\d{1,2})?)\s*€\s*$/u', $line, $share)) {
                $value = (str_starts_with($share[2], '-') ? -1 : 1) * cents(ltrim($share[2], '-'));
                if (($share[1] ?? '') === '') {
                    if ($shareTotal !== null || $value <= 0) {
                        $unknown[] = $header . ' :: invalid or duplicate Share total';
                    }
                    $shareTotal = $value;
                } else {
                    if (isset($shares[$share[1]]) || $value >= 0) {
                        $unknown[] = $header . ' :: invalid or duplicate person share';
                    }
                    $shares[$share[1]] = -$value;
                }
                continue;
            }
            if (!preg_match('/^\s+(Expenses|Expensesextra|Person):([^\s]+)(?:\s+(\d+(?:\.\d{1,2})?)\s*€)?\s*$/u', $line, $posting)) {
                $unknown[] = $header . ' :: ' . trim($line);
                continue;
            }
            $postings[] = [
                'kind' => $posting[1] === 'Expensesextra' ? 'Expenses' : $posting[1],
                'account' => $posting[2],
                'cents' => isset($posting[3]) && $posting[3] !== '' ? cents($posting[3]) : null,
            ];
        }
        $expenses = array_values(array_filter($postings, fn($p) => $p['kind'] === 'Expenses'));
        $people = array_values(array_filter($postings, fn($p) => $p['kind'] === 'Person'));
        $notes = ['Ledger: ' . $header];
        if ($secondaryDate !== null) {
            $notes[] = 'Ledger drugi datum: ' . $secondaryDate;
        }
        foreach ($comments as $comment) {
            if ($comment !== '') {
                $notes[] = $comment;
            }
        }
        if ($expenses !== []) {
            $main = 0;
            $commission = 0;
            $categories = [];
            foreach ($expenses as $posting) {
                if ($posting['cents'] === null) {
                    $unknown[] = $header . ' :: expense without amount';
                    continue;
                }
                if ($posting['account'] === 'StroškiBanke') {
                    $commission += $posting['cents'];
                } else {
                    $main += $posting['cents'];
                    $categories[$posting['account']] = true;
                }
            }
            if (count($people) !== 1 || $people[0]['cents'] !== null || count($categories) !== 1) {
                $unknown[] = $header . ' :: unsupported expense postings';
                continue;
            }
            if (($shareTotal !== null || $shares !== []) &&
                ($shareTotal !== $main + $commission || $shares === [] || array_sum($shares) !== $shareTotal)) {
                $unknown[] = $header . ' :: unbalanced explicit shares';
                continue;
            }
            $transactions[] = compact('date', 'secondaryDate', 'cleared', 'title', 'notes', 'shares') + [
                'type' => 'expense', 'amount' => $main, 'commission' => $commission,
                'category' => array_key_first($categories), 'person' => $people[0]['account'],
            ];
        } elseif ($shareTotal === null && $shares === [] && count($people) === 2 && $people[0]['cents'] !== null && $people[1]['cents'] === null) {
            $transactions[] = compact('date', 'secondaryDate', 'cleared', 'title', 'notes') + [
                'type' => 'payment', 'amount' => $people[0]['cents'],
                'from' => $people[1]['account'], 'to' => $people[0]['account'],
            ];
        } else {
            $unknown[] = $header . ' :: unsupported payment postings';
        }
    }

    $counts = ['expense' => 0, 'payment' => 0];
    $totals = ['expense' => 0, 'commission' => 0, 'payment' => 0];
    foreach ($transactions as $transaction) {
        $counts[$transaction['type']]++;
        $totals[$transaction['type']] += $transaction['amount'];
        $totals['commission'] += $transaction['commission'] ?? 0;
    }
    printf("Parsed %d entries: %d expenses, %d payments.\n", count($transactions), $counts['expense'], $counts['payment']);
    printf("Totals: expenses %s EUR, fees %s EUR, payments %s EUR.\n", money($totals['expense']), money($totals['commission']), money($totals['payment']));
    if ($unknown !== []) {
        fwrite(STDERR, "Unrecognized entries:\n" . implode("\n", $unknown) . "\n");
        fail('Import stopped before changing the database.');
    }
    if ($transactions === []) {
        fail('No transactions found; import stopped.');
    }

    $db = new SQLite3($database, $dryRun ? SQLITE3_OPEN_READONLY : SQLITE3_OPEN_READWRITE);
    $db->enableExceptions(true);
    $db->busyTimeout(5000);
    $people = [];
    $peopleResult = $db->query('SELECT id, name FROM people');
    while ($row = $peopleResult->fetchArray(SQLITE3_ASSOC)) {
        $people[$row['name']] = (int)$row['id'];
    }
    $personMap = ['Andraž' => 'Andraž', 'Borut' => 'Borut', 'Iztok' => 'Izak'];
    foreach ($personMap as $name) {
        if (!isset($people[$name])) {
            fail("Missing person in database: {$name}");
        }
    }
    $categories = [];
    $categoryResult = $db->query('SELECT id, name FROM expense_categories');
    while ($row = $categoryResult->fetchArray(SQLITE3_ASSOC)) {
        $categories[$row['name']] = (int)$row['id'];
    }
    $categoryMap = ['Internet' => 'Internet', 'Najemnina' => 'Najem', 'Stroški' => 'Ostalo', 'NUSZ' => 'Ostalo'];
    foreach ($categoryMap as $name) {
        if (!isset($categories[$name])) {
            fail("Missing category in database: {$name}");
        }
    }
    foreach ($transactions as $transaction) {
        $names = $transaction['type'] === 'expense' ? array_merge([$transaction['person']], array_keys($transaction['shares'])) : [$transaction['from'], $transaction['to']];
        foreach ($names as $name) {
            if (!isset($personMap[$name])) {
                fail("Unknown Ledger person: {$name}");
            }
        }
        if ($transaction['type'] === 'expense' && !isset($categoryMap[$transaction['category']])) {
            fail('Unknown Ledger expense account: ' . $transaction['category']);
        }
    }

    if ($dryRun) {
        echo "Dry run complete. Database unchanged; no backup created.\n";
        exit(0);
    }

    $backupPath = $database . '.before-ledger-' . date('Ymd-His') . '.bak';
    if (file_exists($backupPath)) {
        fail("Backup already exists: {$backupPath}");
    }
    $backup = new SQLite3($backupPath, SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);
    $backup->enableExceptions(true);
    if (!$db->backup($backup)) {
        fail('SQLite backup failed.');
    }
    $backup->close();
    echo "Backup: {$backupPath}\n";

    $db->exec('PRAGMA foreign_keys = ON');
    $db->exec('BEGIN IMMEDIATE');
    try {
        // Attachments belong to existing expenses and must not outlive replacement.
        $db->exec('DELETE FROM expense_attachments');
        $db->exec('DELETE FROM expense_splits');
        $db->exec('DELETE FROM expenses');
        $db->exec('DELETE FROM payments');
        $expenseStmt = $db->prepare('INSERT INTO expenses (title, amount, commission, expense_date, paid_by_id, notes, created, modified, expense_category_id, supplier_id, is_paid, paid_date) VALUES (:title, :amount, :commission, :date, :person, :notes, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, :category, NULL, :paid, :paid_date)');
        $splitStmt = $db->prepare('INSERT INTO expense_splits (expense_id, person_id, share_ratio, created) VALUES (:expense, :person, :ratio, CURRENT_TIMESTAMP)');
        $paymentStmt = $db->prepare('INSERT INTO payments (from_person_id, to_person_id, amount, payment_date, notes, created, modified) VALUES (:from, :to, :amount, :date, :notes, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)');
        foreach ($transactions as $transaction) {
            $notes = implode("\n", $transaction['notes']);
            if ($transaction['type'] === 'expense') {
                $expenseStmt->reset();
                $expenseStmt->bindValue(':title', $transaction['title'], SQLITE3_TEXT);
                $expenseStmt->bindValue(':amount', money($transaction['amount']), SQLITE3_TEXT);
                $expenseStmt->bindValue(':commission', money($transaction['commission']), SQLITE3_TEXT);
                $expenseStmt->bindValue(':date', $transaction['date'], SQLITE3_TEXT);
                $expenseStmt->bindValue(':person', $people[$personMap[$transaction['person']]], SQLITE3_INTEGER);
                $expenseStmt->bindValue(':notes', $notes, SQLITE3_TEXT);
                $expenseStmt->bindValue(':category', $categories[$categoryMap[$transaction['category']]], SQLITE3_INTEGER);
                $expenseStmt->bindValue(':paid', $transaction['cleared'] ? 1 : 0, SQLITE3_INTEGER);
                $expenseStmt->bindValue(':paid_date', $transaction['cleared'] ? ($transaction['secondaryDate'] ?? $transaction['date']) : null, SQLITE3_TEXT);
                $expenseStmt->execute();
                $expenseId = $db->lastInsertRowID();
                $splitNames = $transaction['date'] < '2026-08-01' ? ['Andraž', 'Iztok', 'Borut'] : ['Andraž', 'Borut'];
                if ($transaction['shares'] !== []) {
                    $splitNames = array_keys($transaction['shares']);
                }
                foreach ($splitNames as $name) {
                    $splitStmt->reset();
                    $splitStmt->bindValue(':expense', $expenseId, SQLITE3_INTEGER);
                    $splitStmt->bindValue(':person', $people[$personMap[$name]], SQLITE3_INTEGER);
                    // SQLite retains the precision needed to preserve explicit cent amounts.
                    $ratio = $transaction['shares'] !== []
                        ? sprintf('%.15f', $transaction['shares'][$name] / ($transaction['amount'] + $transaction['commission']))
                        : (count($splitNames) === 3 ? '0.3333' : '0.5000');
                    $splitStmt->bindValue(':ratio', $ratio, SQLITE3_TEXT);
                    $splitStmt->execute();
                }
            } else {
                $paymentStmt->reset();
                $paymentStmt->bindValue(':from', $people[$personMap[$transaction['from']]], SQLITE3_INTEGER);
                $paymentStmt->bindValue(':to', $people[$personMap[$transaction['to']]], SQLITE3_INTEGER);
                $paymentStmt->bindValue(':amount', money($transaction['amount']), SQLITE3_TEXT);
                $paymentStmt->bindValue(':date', $transaction['date'], SQLITE3_TEXT);
                $paymentStmt->bindValue(':notes', $notes, SQLITE3_TEXT);
                $paymentStmt->execute();
            }
        }
        $db->exec('COMMIT');
    } catch (Throwable $error) {
        $db->exec('ROLLBACK');
        throw $error;
    }
    echo "Import complete. Re-running replaces the imported expense and payment data without duplicates.\n";
} catch (Throwable $error) {
    fwrite(STDERR, $error->getMessage() . "\n");
    exit(1);
}
