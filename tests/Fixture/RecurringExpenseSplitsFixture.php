<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RecurringExpenseSplitsFixture
 */
class RecurringExpenseSplitsFixture extends TestFixture
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
                'recurring_expense_id' => 1,
                'person_id' => 1,
                'created' => '2025-12-09 19:45:01',
            ],
        ];
        parent::init();
    }
}
