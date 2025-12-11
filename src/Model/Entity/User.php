<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher;

class User extends Entity {
    protected array $_accessible = [
        'username' => true,
        'password' => true,
        'email' => true,
        'first_name' => true,
        'last_name' => true,
        'role' => true,
        'is_active' => true,
        'last_login' => true,
        'created' => true,
        'modified' => true,
    ];

    protected array $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password): ?string {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
        return null;
    }

    public function getFullName(): string {
        return $this->first_name . ' ' . $this->last_name;
    }
}
