<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class AddCategoryAndSupplierToExpenses extends BaseMigration {
    public function up(): void {
        $table = $this->table('expenses');

        $table->addColumn('expense_category_id', 'integer', [
            'null' => true,
            'after' => 'paid_by_id',
        ]);

        $table->addColumn('supplier_id', 'integer', [
            'null' => true,
            'after' => 'expense_category_id',
        ]);

        $table->addForeignKey('expense_category_id', 'expense_categories', 'id', [
            'delete' => 'SET_NULL',
            'update' => 'CASCADE'
        ]);

        $table->addForeignKey('supplier_id', 'suppliers', 'id', [
            'delete' => 'SET_NULL',
            'update' => 'CASCADE'
        ]);

        $table->update();
    }
}
