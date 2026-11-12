<?php
declare(strict_types=1);

namespace App\Service;

use App\Model\Entity\RecurringExpense;
use Cake\I18n\Date;
use Cake\ORM\Locator\LocatorAwareTrait;
use DateTimeImmutable;
use DateTimeZone;
use DomainException;

class RecurringExpenseGenerator
{
    use LocatorAwareTrait;

    public function today(): DateTimeImmutable
    {
        return new DateTimeImmutable('today', new DateTimeZone('Europe/Ljubljana'));
    }

    private function due(RecurringExpense $item, DateTimeImmutable $today): DateTimeImmutable
    {
        return $today->setDate(
            (int)$today->format('Y'),
            (int)$today->format('m'),
            min((int)$item->day_of_month, (int)$today->format('t')),
        );
    }

    /**
     * Read-only check shared by reminders and generation.
     *
     * @return array{status: string, expense_id: int|null}
     */
    public function monthlyStatus(RecurringExpense $item, ?DateTimeImmutable $today = null): array
    {
        $today ??= $this->today();
        $month = $today->format('Y-m-01');
        $expenses = $this->fetchTable('Expenses');
        $linked = $expenses->find()->where([
            'recurring_expense_id' => $item->id,
            'recurrence_month' => $month,
        ])->first();
        if ($linked) {
            return ['status' => 'existing', 'expense_id' => (int)$linked->id];
        }
        if (!$item->last_added_date || $item->last_added_date->format('Y-m') !== $today->format('Y-m')) {
            return ['status' => 'missing', 'expense_id' => null];
        }

        // Older automatic runs used the due date; manual runs used last_added_date.
        $dates = array_unique([$item->last_added_date->format('Y-m-d'), $this->due($item, $today)->format('Y-m-d')]);
        $matches = $expenses->find()->where([
            'recurring_expense_id IS' => null,
            'recurrence_month IS' => null,
            'expense_date IN' => $dates,
            'title' => $item->title,
            'amount' => $item->amount,
            'commission' => $item->commission,
            'paid_by_id' => $item->paid_by_id,
        ])->limit(2)->all()->toList();
        if (!$matches) {
            return ['status' => 'missing', 'expense_id' => null];
        }

        // Never assign a legacy expense that could also belong to another template.
        $otherTemplates = $this->fetchTable('RecurringExpenses')->find()->where([
            'id !=' => $item->id,
            'title' => $item->title,
            'amount' => $item->amount,
            'commission' => $item->commission,
            'paid_by_id' => $item->paid_by_id,
            'last_added_date >=' => $month,
            'last_added_date <' => $today->modify('first day of next month')->format('Y-m-d'),
        ])->all();
        foreach ($otherTemplates as $other) {
            $otherDates = [$other->last_added_date->format('Y-m-d'), $this->due($other, $today)->format('Y-m-d')];
            foreach ($matches as $match) {
                if (in_array($match->expense_date->format('Y-m-d'), $otherDates, true)) {
                    return ['status' => 'ambiguous', 'expense_id' => null];
                }
            }
        }

        return count($matches) === 1
            ? ['status' => 'legacy', 'expense_id' => (int)$matches[0]->id]
            : ['status' => 'ambiguous', 'expense_id' => null];
    }

    public function needsReminder(RecurringExpense $item, ?DateTimeImmutable $today = null): bool
    {
        $today ??= $this->today();

        return $item->is_active && $today >= $this->due($item, $today)
            && in_array($this->monthlyStatus($item, $today)['status'], ['missing', 'ambiguous'], true);
    }

    public function generate(int $id, bool $automatic = true, ?DateTimeImmutable $today = null): bool
    {
        $today ??= $this->today();
        $table = $this->fetchTable('RecurringExpenses');
        // Load metadata before acquiring SQLite's write lock.
        $table->getSchema();
        if ($table->getConnection()->getDriver() instanceof \Cake\Database\Driver\Sqlite) {
            $table->getConnection()->execute('PRAGMA busy_timeout = 5000');
        }
        try {
            $result = $table->getConnection()->transactional(function () use ($table, $id, $automatic, $today) {
                // Acquire the template's write lock before reading monthly state.
                // This also avoids SQLite read-to-write lock upgrade races.
                $table->updateAll(['id' => $id], ['id' => $id]);
                $item = $table->get($id, contain: ['RecurringExpenseSplits']);
                $due = $this->due($item, $today);
                if (!$item->is_active || ($automatic && $today < $due)) {
                    return false;
                }
                $status = $this->monthlyStatus($item, $today);
                if ($status['status'] === 'existing') {
                    return false;
                }
                if ($status['status'] === 'ambiguous') {
                    throw new DomainException('Več starih stroškov ali predlog se ujema. Pred dodajanjem je treba razjasniti povezavo.');
                }
                $expenses = $this->fetchTable('Expenses');
                if ($status['status'] === 'legacy') {
                    // Conditional update prevents two templates from claiming the same old row.
                    $claimed = $expenses->updateAll([
                        'recurring_expense_id' => $id,
                        'recurrence_month' => $today->format('Y-m-01'),
                    ], [
                        'id' => $status['expense_id'],
                        'recurring_expense_id IS' => null,
                        'recurrence_month IS' => null,
                    ]);
                    if (!$claimed) {
                        throw new DomainException('Povezava starega stroška se je spremenila. Osvežite stran in poskusite znova.');
                    }

                    // Cake rolls back callbacks returning false. Commit the link first.
                    return 'linked';
                }
                $splits = $item->recurring_expense_splits;
                $expense = $expenses->newEntity([
                    'title' => $item->title,
                    'expense_category_id' => $item->expense_category_id,
                    'amount' => $item->amount,
                    'commission' => $item->commission,
                    'paid_by_id' => $item->paid_by_id,
                    'expense_date' => new Date(($automatic ? $due : $today)->format('Y-m-d')),
                    'expense_splits' => array_map(fn($s) => ['person_id' => $s->person_id, 'share_ratio' => 1 / count($splits)], $splits),
                ], ['associated' => ['ExpenseSplits']]);
                // These fields are internal and intentionally not mass assignable from forms.
                $expense->set('recurring_expense_id', $id);
                $expense->set('recurrence_month', new Date($today->format('Y-m-01')));
                $expenses->saveOrFail($expense);
                $table->updateAll(['last_added_date' => $today->format('Y-m-d')], ['id' => $id]);

                return true;
            });

            return $result === true;
        } catch (\Cake\Database\Exception\QueryException $e) {
            // A concurrent winner may have inserted the same template/month.
            if ($this->fetchTable('Expenses')->exists([
                'recurring_expense_id' => $id,
                'recurrence_month' => $today->format('Y-m-01'),
            ])) {
                return false;
            }
            throw $e;
        }
    }
}
