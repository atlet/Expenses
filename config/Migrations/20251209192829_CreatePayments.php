<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePayments extends BaseMigration {
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function up(): void {
        $table = $this->table('payments');
        $table->addColumn('from_person_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('to_person_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('amount', 'decimal', [
            'precision' => 10,
            'scale' => 2,
            'null' => false,
        ]);
        $table->addColumn('payment_date', 'date', [
            'null' => false,
        ]);
        $table->addColumn('notes', 'text', [
            'null' => true,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('from_person_id', 'people', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);
        $table->addForeignKey('to_person_id', 'people', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);

        $table->create();
    }

    public function down(): void {
        $this->table('payments')->drop()->save();
    }
}
