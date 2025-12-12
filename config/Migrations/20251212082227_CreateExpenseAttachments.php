<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class CreateExpenseAttachments extends BaseMigration {
    public function up(): void {
        $table = $this->table('expense_attachments');
        $table->addColumn('expense_id', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('filename', 'string', [
            'limit' => 255,
            'null' => false,
            'comment' => 'Original filename',
        ]);
        $table->addColumn('file_path', 'string', [
            'limit' => 500,
            'null' => false,
            'comment' => 'Path to file on disk',
        ]);
        $table->addColumn('file_size', 'integer', [
            'null' => false,
            'comment' => 'File size in bytes',
        ]);
        $table->addColumn('mime_type', 'string', [
            'limit' => 100,
            'null' => false,
        ]);
        $table->addColumn('uploaded_by', 'integer', [
            'null' => false,
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
        ]);

        $table->addForeignKey('expense_id', 'expenses', 'id', [
            'delete' => 'CASCADE',
            'update' => 'CASCADE'
        ]);

        $table->addForeignKey('uploaded_by', 'users', 'id', [
            'delete' => 'RESTRICT',
            'update' => 'CASCADE'
        ]);

        $table->create();
    }
}
