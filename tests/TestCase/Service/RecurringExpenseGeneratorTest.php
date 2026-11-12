<?php
declare(strict_types=1);

namespace App\Test\TestCase\Service;

use App\Service\RecurringExpenseGenerator;
use Cake\I18n\Date;
use Cake\TestSuite\TestCase;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;
use RuntimeException;

class RecurringExpenseGeneratorTest extends TestCase
{
    protected array $fixtures = [
        'app.People', 'app.RecurringExpenses', 'app.RecurringExpenseSplits',
        'app.Expenses', 'app.ExpenseSplits',
    ];

    private RecurringExpenseGenerator $generator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->generator = new RecurringExpenseGenerator();
        $this->generator->setTableLocator($this->getTableLocator());
        $this->getTableLocator()->get('RecurringExpenses')->updateAll([
            'last_added_date' => '2026-11-12',
            'day_of_month' => 1,
        ], ['id' => 1]);
    }

    private function date(string $date = '2026-11-12'): DateTimeImmutable
    {
        return new DateTimeImmutable($date, new DateTimeZone('Europe/Ljubljana'));
    }

    private function item()
    {
        return $this->getTableLocator()->get('RecurringExpenses')->get(1);
    }

    private function legacy(string $date = '2026-11-12'): int
    {
        $expenses = $this->getTableLocator()->get('Expenses');
        $expense = $expenses->newEntity([
            'title' => $this->item()->title,
            'amount' => '1.50',
            'commission' => '1.50',
            'paid_by_id' => 1,
            'expense_date' => new Date($date),
        ]);
        $expenses->saveOrFail($expense);

        return (int)$expense->id;
    }

    public function testMissingExpenseCanBeRecreatedDespiteLastAddedDate(): void
    {
        $this->assertTrue($this->generator->needsReminder($this->item(), $this->date()));
        $this->assertTrue($this->generator->generate(1, false, $this->date()));
        $this->assertFalse($this->generator->generate(1, true, $this->date()));
        $this->assertFalse($this->generator->needsReminder($this->item(), $this->date()));
        $expenses = $this->getTableLocator()->get('Expenses');
        $expense = $expenses->find()->where(['recurring_expense_id' => 1])->firstOrFail();
        $this->assertSame('2026-11-01', $expense->recurrence_month->format('Y-m-d'));
        $this->assertSame('2026-11-12', $expense->expense_date->format('Y-m-d'));
        $this->assertSame(1, $this->getTableLocator()->get('ExpenseSplits')->find()->where(['expense_id' => $expense->id])->count());
        $expenses->deleteOrFail($expense);
        $this->assertTrue($this->generator->needsReminder($this->item(), $this->date()));
        $this->assertTrue($this->generator->generate(1, false, $this->date()));
    }

    public function testUniqueLegacyExpenseIsLinkedWithoutChangingHistory(): void
    {
        $id = $this->legacy();
        $expenses = $this->getTableLocator()->get('Expenses');
        $before = $expenses->get($id)->toArray();
        $this->assertFalse($this->generator->needsReminder($this->item(), $this->date()));
        $this->assertFalse($this->generator->generate(1, false, $this->date()));
        $after = $expenses->get($id)->toArray();
        $this->assertSame(1, $after['recurring_expense_id']);
        unset($before['recurring_expense_id'], $before['recurrence_month'], $after['recurring_expense_id'], $after['recurrence_month']);
        $this->assertEquals($before, $after);
    }

    public function testLegacyAutomaticExpenseUsesDueDate(): void
    {
        $id = $this->legacy('2026-11-01');
        $this->assertFalse($this->generator->generate(1, true, $this->date()));
        $this->assertSame(1, $this->getTableLocator()->get('Expenses')->get($id)->recurring_expense_id);
    }

    public function testAmbiguousLegacyExpensesDoNotCreateDuplicates(): void
    {
        $this->legacy();
        $this->legacy();
        $this->assertTrue($this->generator->needsReminder($this->item(), $this->date()));
        $this->expectException(DomainException::class);
        $this->generator->generate(1, false, $this->date());
    }

    public function testLegacyExpenseCannotBeClaimedByTwoTemplates(): void
    {
        $this->legacy();
        $templates = $this->getTableLocator()->get('RecurringExpenses');
        $other = $templates->newEntity([
            'title' => $this->item()->title, 'amount' => '1.50', 'commission' => '1.50',
            'paid_by_id' => 1, 'day_of_month' => 1, 'is_active' => true,
            'last_added_date' => new Date('2026-11-12'),
        ]);
        $templates->saveOrFail($other);
        $this->expectException(DomainException::class);
        $this->generator->generate(1, false, $this->date());
    }

    public function testInactiveTemplateAndManualEarlyGeneration(): void
    {
        $templates = $this->getTableLocator()->get('RecurringExpenses');
        $templates->updateAll(['is_active' => false], ['id' => 1]);
        $this->assertFalse($this->generator->generate(1, false, $this->date()));
        $this->assertFalse($this->generator->needsReminder($this->item(), $this->date()));
        $templates->updateAll(['is_active' => true, 'day_of_month' => 25], ['id' => 1]);
        $this->assertFalse($this->generator->generate(1, true, $this->date()));
        $this->assertFalse($this->generator->needsReminder($this->item(), $this->date()));
        $this->assertTrue($this->generator->generate(1, false, $this->date()));
    }

    public function testShortMonthAndYearBoundary(): void
    {
        $templates = $this->getTableLocator()->get('RecurringExpenses');
        $templates->updateAll(['day_of_month' => 31, 'last_added_date' => '2025-12-31'], ['id' => 1]);
        $this->assertFalse($this->generator->generate(1, true, $this->date('2026-02-27')));
        $this->assertTrue($this->generator->generate(1, true, $this->date('2026-02-28')));
        $expense = $this->getTableLocator()->get('Expenses')->find()->where(['recurring_expense_id' => 1])->firstOrFail();
        $this->assertSame('2026-02-28', $expense->expense_date->format('Y-m-d'));
        $this->assertTrue($this->generator->generate(1, true, $this->date('2026-12-31')));
        $this->assertTrue($this->generator->generate(1, true, $this->date('2027-01-31')));
    }

    public function testFailureRollsBackExpenseSplitsAndLastAddedDate(): void
    {
        $templates = $this->getTableLocator()->get('RecurringExpenses');
        $templates->updateAll(['last_added_date' => '2026-10-01'], ['id' => 1]);
        $expenses = $this->getTableLocator()->get('Expenses');
        $count = $expenses->find()->count();
        $splits = $this->getTableLocator()->get('ExpenseSplits')->find()->count();
        $listener = function (): void {
            throw new RuntimeException('Simulated failure after saving');
        };
        $expenses->getEventManager()->on('Model.afterSave', $listener);
        try {
            $this->generator->generate(1, false, $this->date());
            $this->fail('Expected failure');
        } catch (RuntimeException $e) {
            $this->assertSame('Simulated failure after saving', $e->getMessage());
        } finally {
            $expenses->getEventManager()->off('Model.afterSave', $listener);
        }
        $this->assertSame($count, $expenses->find()->count());
        $this->assertSame($splits, $this->getTableLocator()->get('ExpenseSplits')->find()->count());
        $this->assertSame('2026-10-01', $this->item()->last_added_date->format('Y-m-d'));
    }

    public function testDatabaseRejectsDuplicateTemplateMonth(): void
    {
        $this->assertTrue($this->generator->generate(1, false, $this->date()));
        $expenses = $this->getTableLocator()->get('Expenses');
        $this->expectException(\Cake\Database\Exception\QueryException::class);
        $expenses->insertQuery()->insert([
            'title', 'amount', 'commission', 'paid_by_id', 'expense_date',
            'created', 'modified', 'recurring_expense_id', 'recurrence_month',
        ])->values([
            'title' => 'Duplicate', 'amount' => 1, 'commission' => 0, 'paid_by_id' => 1,
            'expense_date' => '2026-11-12', 'created' => '2026-11-12 12:00:00',
            'modified' => '2026-11-12 12:00:00', 'recurring_expense_id' => 1,
            'recurrence_month' => '2026-11-01',
        ])->execute();
    }

    public function testConcurrentGenerationCreatesOneExpense(): void
    {
        $connection = $this->getTableLocator()->get('Expenses')->getConnection();
        if (!$connection->getDriver() instanceof \Cake\Database\Driver\Sqlite || !function_exists('proc_open')) {
            $this->markTestSkipped('Requires file-backed SQLite and proc_open.');
        }
        $database = $connection->config()['database'];
        if ($database === ':memory:') {
            $this->markTestSkipped('Requires file-backed SQLite.');
        }
        $code = <<<'CHILD'
require 'vendor/autoload.php';
require 'config/bootstrap.php';
\Cake\Datasource\ConnectionManager::drop('default');
\Cake\Datasource\ConnectionManager::setConfig('default', [
    'className' => \Cake\Database\Connection::class,
    'driver' => \Cake\Database\Driver\Sqlite::class,
    'database' => $argv[1],
    'cacheMetadata' => false,
]);
$expenses = \Cake\ORM\TableRegistry::getTableLocator()->get('Expenses');
$expenses->getEventManager()->on('Model.afterSave', function () { usleep(150000); });
$generator = new \App\Service\RecurringExpenseGenerator();
echo $generator->generate(1, false, new \DateTimeImmutable('2026-11-12', new \DateTimeZone('Europe/Ljubljana'))) ? 'added' : 'skipped';
CHILD;
        $processes = [];
        for ($i = 0; $i < 2; $i++) {
            $pipes = [];
            $process = proc_open([PHP_BINARY, '-r', $code, $database], [
                0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w'],
            ], $pipes, ROOT);
            $this->assertIsResource($process);
            fclose($pipes[0]);
            $processes[] = [$process, $pipes];
        }
        $results = [];
        foreach ($processes as [$process, $pipes]) {
            $results[] = stream_get_contents($pipes[1]);
            $error = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $this->assertSame(0, proc_close($process), $error);
        }
        sort($results);
        $this->assertSame(['added', 'skipped'], $results);
        $this->assertSame(1, $this->getTableLocator()->get('Expenses')->find()->where([
            'recurring_expense_id' => 1, 'recurrence_month' => '2026-11-01',
        ])->count());
    }

    public function testDeletingTemplatePreservesExpense(): void
    {
        $this->generator->generate(1, false, $this->date());
        $expenses = $this->getTableLocator()->get('Expenses');
        $expense = $expenses->find()->where(['recurring_expense_id' => 1])->firstOrFail();
        $this->getTableLocator()->get('RecurringExpenses')->deleteOrFail($this->item());
        $this->assertNull($expenses->get($expense->id)->recurring_expense_id);
        $this->assertSame('2026-11-01', $expenses->get($expense->id)->recurrence_month->format('Y-m-d'));
    }
}
