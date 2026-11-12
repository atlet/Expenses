<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class LinkRecurringExpenses extends BaseMigration
{
    public function change(): void
    {
        $this->table('expenses')
            ->addColumn('recurring_expense_id', 'integer', ['null' => true, 'default' => null])
            ->addColumn('recurrence_month', 'date', ['null' => true, 'default' => null])
            ->addForeignKey('recurring_expense_id', 'recurring_expenses', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->addIndex(['recurring_expense_id', 'recurrence_month'], [
                'unique' => true,
                'name' => 'expenses_recurring_month_unique',
            ])
            ->update();
    }
}
