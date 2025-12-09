<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecurringExpensesFixture
 */
class RecurringExpensesFixture extends TestFixture
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
                'title' => 'Lorem ipsum dolor sit amet',
                'amount' => 1.5,
                'commission' => 1.5,
                'day_of_month' => 1,
                'paid_by_id' => 1,
                'last_added_date' => '2025-12-09',
                'is_active' => 1,
                'created' => '2025-12-09 19:44:57',
                'modified' => '2025-12-09 19:44:57',
            ],
        ];
        parent::init();
    }
}
