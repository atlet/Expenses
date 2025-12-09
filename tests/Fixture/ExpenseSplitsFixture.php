<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExpenseSplitsFixture
 */
class ExpenseSplitsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'expense_id' => 1,
                'person_id' => 1,
                'share_ratio' => 1.5,
                'created' => '2025-12-09 19:44:39',
            ],
        ];
        parent::init();
    }
}
