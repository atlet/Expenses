<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class AddPaidStatusToExpenses extends BaseMigration {
    public function up(): void {
        $table = $this->table('expenses');

        $table->addColumn('is_paid', 'boolean', [
            'default' => false,
            'null' => false,
            'after' => 'expense_date',
            'comment' => 'Whether the expense has been paid',
        ]);

        $table->addColumn('paid_date', 'date', [
            'null' => true,
            'after' => 'is_paid',
            'comment' => 'Date when expense was actually paid',
        ]);

        $table->update();
    }
}
