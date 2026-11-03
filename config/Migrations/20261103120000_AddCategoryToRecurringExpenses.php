<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddCategoryToRecurringExpenses extends BaseMigration
{
    public function change(): void
    {
        $this->table('recurring_expenses')
            ->addColumn('expense_category_id', 'integer', ['null' => true, 'default' => null])
            ->addForeignKey('expense_category_id', 'expense_categories', 'id', [
                'delete' => 'SET_NULL',
                'update' => 'CASCADE',
            ])
            ->update();
    }
}
