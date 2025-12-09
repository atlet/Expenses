<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateExpenseSplits extends BaseMigration {
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function up(): void {
        $table = $this->table('expense_splits');
        $table->addColumn('expense_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('person_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('share_ratio', 'decimal', [
            'precision' => 5,
            'scale' => 4,
            'null' => false,
            'comment' => 'Delež (npr. 0.3333 za tretjino)',
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('expense_id', 'expenses', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);
        $table->addForeignKey('person_id', 'people', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);

        $table->addIndex(['expense_id', 'person_id'], ['unique' => true]);
        $table->create();
    }

    public function down(): void {
        $this->table('expense_splits')->drop()->save();
    }
}
