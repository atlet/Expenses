<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecurringExpenseSplitsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecurringExpenseSplitsTable Test Case
 */
class RecurringExpenseSplitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecurringExpenseSplitsTable
     */
    protected $RecurringExpenseSplits;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecurringExpenseSplits',
        'app.RecurringExpenses',
        'app.People',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecurringExpenseSplits') ? [] : ['className' => RecurringExpenseSplitsTable::class];
        $this->RecurringExpenseSplits = $this->getTableLocator()->get('RecurringExpenseSplits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecurringExpenseSplits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecurringExpenseSplitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecurringExpenseSplitsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
