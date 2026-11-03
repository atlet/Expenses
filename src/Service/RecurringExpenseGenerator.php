<?php
declare(strict_types=1);
namespace App\Service;

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\I18n\Date;

class RecurringExpenseGenerator
{
    use LocatorAwareTrait;

    public function generate(int $id, bool $automatic = true): bool
    {
        $table = $this->fetchTable('RecurringExpenses');
        return $table->getConnection()->transactional(function () use ($table, $id, $automatic) {
            $today = new \DateTimeImmutable('today', new \DateTimeZone('Europe/Ljubljana'));
            $first = $today->format('Y-m-01');
            $item = $table->get($id, contain: ['RecurringExpenseSplits']);
            $due = $today->setDate((int)$today->format('Y'), (int)$today->format('m'), min((int)$item->day_of_month, (int)$today->format('t')));
            if (!$item->is_active || ($automatic && $today < $due)) {
                return false;
            }
            $updated = $table->updateAll(['last_added_date' => $today->format('Y-m-d')], [
                'id' => $id,
                'OR' => [['last_added_date IS' => null], ['last_added_date <' => $first]],
            ]);
            if (!$updated) {
                return false;
            }
            $splits = $item->recurring_expense_splits;
            $expenses = $this->fetchTable('Expenses');
            $expense = $expenses->newEntity([
                'title' => $item->title,
                'expense_category_id' => $item->expense_category_id,
                'amount' => $item->amount,
                'commission' => $item->commission,
                'paid_by_id' => $item->paid_by_id,
                'expense_date' => new Date(($automatic ? $due : $today)->format('Y-m-d')),
                'expense_splits' => array_map(fn($s) => ['person_id' => $s->person_id, 'share_ratio' => 1 / count($splits)], $splits),
            ], ['associated' => ['ExpenseSplits']]);
            $expenses->saveOrFail($expense);
            return true;
        });
    }
}
