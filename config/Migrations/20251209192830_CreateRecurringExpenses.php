<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateRecurringExpenses extends BaseMigration {
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function up(): void {
        $table = $this->table('recurring_expenses');
        $table->addColumn('title', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('amount', 'decimal', [
            'precision' => 10,
            'scale' => 2,
            'null' => false,
        ]);
        $table->addColumn('commission', 'decimal', [
            'precision' => 10,
            'scale' => 2,
            'default' => 0.00,
            'null' => false,
        ]);
        $table->addColumn('day_of_month', 'integer', [
            'null' => false,
            'comment' => 'Dan v mesecu (1-28)',
        ]);
        $table->addColumn('paid_by_id', 'integer', [
            'null' => false,
        ]);        
        $table->addColumn('last_added_date', 'date', [
            'null' => true,
            'comment' => 'Datum zadnjega dodanega stroška',
        ]);
        $table->addColumn('is_active', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('paid_by_id', 'people', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);

        $table->create();
    }

    public function down(): void {
        $this->table('recurring_expenses')->drop()->save();
    }
}
