<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RecurringExpensesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RecurringExpensesTable Test Case
 */
class RecurringExpensesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RecurringExpensesTable
     */
    protected $RecurringExpenses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.RecurringExpenses',
        'app.PaidBies',
        'app.RecurringExpenseSplits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('RecurringExpenses') ? [] : ['className' => RecurringExpensesTable::class];
        $this->RecurringExpenses = $this->getTableLocator()->get('RecurringExpenses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->RecurringExpenses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\RecurringExpensesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\RecurringExpensesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
