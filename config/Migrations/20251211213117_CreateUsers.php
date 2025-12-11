<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsers extends BaseMigration {
    public function up(): void {
        $table = $this->table('users');
        $table->addColumn('username', 'string', [
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('password', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('email', 'string', [
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('first_name', 'string', [
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('last_name', 'string', [
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('role', 'string', [
            'limit' => 20,
            'default' => 'user',
            'null' => false,
            'comment' => 'admin or user',
        ]);
        $table->addColumn('is_active', 'boolean', [
            'default' => true,
            'null' => false,
        ]);
        $table->addColumn('last_login', 'datetime', [
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

        $table->addIndex(['username'], ['unique' => true]);
        $table->addIndex(['email'], ['unique' => true]);

        $table->create();
    }
}
