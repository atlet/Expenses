<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateRecurringExpenseSplits extends BaseMigration {
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function up(): void {
        $table = $this->table('recurring_expense_splits');
        $table->addColumn('recurring_expense_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('person_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('recurring_expense_id', 'recurring_expenses', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);
        $table->addForeignKey('person_id', 'people', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);

        $table->addIndex(['recurring_expense_id', 'person_id'], ['unique' => true]);
        $table->create();
    }

    public function down(): void {
        $this->table('recurring_expense_splits')->drop()->save();
    }
}
