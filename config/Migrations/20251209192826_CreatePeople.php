<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreatePeople extends BaseMigration {
    public function up(): void {
        $table = $this->table('people');
        $table->addColumn('name', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('email', 'string', [
            'limit' => 255,
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
        $table->create();
    }

    public function down(): void {
        $this->table('people')->drop()->save();
    }
}
