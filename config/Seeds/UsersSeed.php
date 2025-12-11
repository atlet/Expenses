<?php

declare(strict_types=1);

use Migrations\BaseSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class UsersSeed extends BaseSeed {
    public function run(): void {

        $data = [
            [
                'username' => 'admin',
                'password' => (new DefaultPasswordHasher())->hash('admin123'), // SPREMENITE TO GESLO!
                'email' => 'admin@example.com',
                'first_name' => 'Admin',
                'last_name' => 'User',
                'role' => 'admin',
                'is_active' => true,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
