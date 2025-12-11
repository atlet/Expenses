<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateExpenseCategories extends BaseMigration {
    public function up(): void {
        $table = $this->table('expense_categories');
        $table->addColumn('name', 'string', [
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('name_en', 'string', [
            'limit' => 100,
            'null' => false,
            'comment' => 'English name',
        ]);
        $table->addColumn('color', 'string', [
            'limit' => 7,
            'null' => false,
            'default' => '#6c757d',
            'comment' => 'Hex color code',
        ]);
        $table->addColumn('icon', 'string', [
            'limit' => 50,
            'null' => true,
            'comment' => 'Font Awesome icon class',
        ]);
        $table->addColumn('description', 'text', [
            'null' => true,
        ]);
        $table->addColumn('is_active', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->addColumn('sort_order', 'integer', [
            'default' => 0,
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

        $table->create();
    }
}
