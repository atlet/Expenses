<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSuppliers extends BaseMigration {
    public function up(): void {
        $table = $this->table('suppliers');
        $table->addColumn('name', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('contact_person', 'string', [
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('email', 'string', [
            'limit' => 255,
            'null' => true,
        ]);
        $table->addColumn('phone', 'string', [
            'limit' => 50,
            'null' => true,
        ]);
        $table->addColumn('address', 'text', [
            'null' => true,
        ]);
        $table->addColumn('tax_number', 'string', [
            'limit' => 50,
            'null' => true,
            'comment' => 'VAT/Tax ID',
        ]);
        $table->addColumn('notes', 'text', [
            'null' => true,
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

        $table->create();
    }
}
