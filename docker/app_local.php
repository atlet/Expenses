<?php
declare(strict_types=1);

$salt = env('SECURITY_SALT');
if (!$salt) {
    throw new RuntimeException('SECURITY_SALT must be configured.');
}

return [
    'debug' => filter_var(env('DEBUG', false), FILTER_VALIDATE_BOOLEAN),
    'App' => ['fullBaseUrl' => env('APP_FULL_BASE_URL', 'http://localhost:8080')],
    'Security' => ['salt' => $salt],
    'Datasources' => [
        'default' => [
            'driver' => \Cake\Database\Driver\Sqlite::class,
            'database' => ROOT . DS . 'db' . DS . 'app.sqlite',
            'encoding' => 'utf8',
            'timezone' => null,
            'flags' => [],
        ],
    ],
    'Session' => ['defaults' => 'cake'],
];
