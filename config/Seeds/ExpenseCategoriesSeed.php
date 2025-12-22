<?php

declare(strict_types=1);

use Migrations\BaseSeed;

class ExpenseCategoriesSeed extends BaseSeed {
    public function run(): void {
        $data = [
            [
                'name' => 'Internet',
                'color' => '#007bff',
                'icon' => 'fa-wifi',
                'description' => 'Stroški internetne povezave',
                'sort_order' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Elektrika',
                'color' => '#ffc107',
                'icon' => 'fa-bolt',
                'description' => 'Stroški električne energije',
                'sort_order' => 2,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Najem',
                'color' => '#28a745',
                'icon' => 'fa-building',
                'description' => 'Najemnina za pisarniški prostor',
                'sort_order' => 3,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Čiščenje',
                'color' => '#17a2b8',
                'icon' => 'fa-broom',
                'description' => 'Stroški čiščenja',
                'sort_order' => 4,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pisarniški material',
                'color' => '#6610f2',
                'icon' => 'fa-pen',
                'description' => 'Papir, pisala, itd.',
                'sort_order' => 5,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Telefon',
                'color' => '#e83e8c',
                'icon' => 'fa-phone',
                'description' => 'Telefonski stroški',
                'sort_order' => 6,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Vzdrževanje',
                'color' => '#fd7e14',
                'icon' => 'fa-wrench',
                'description' => 'Popravila in vzdrževanje',
                'sort_order' => 7,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ostalo',
                'color' => '#6c757d',
                'icon' => 'fa-ellipsis-h',
                'description' => 'Drugi stroški',
                'sort_order' => 99,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s'),
            ],
        ];

        $table = $this->table('expense_categories');
        $table->insert($data)->save();
    }
}
