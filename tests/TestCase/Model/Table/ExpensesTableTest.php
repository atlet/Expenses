<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExpensesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExpensesTable Test Case
 */
class ExpensesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExpensesTable
     */
    protected $Expenses;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Expenses',
        'app.PaidBies',
        'app.ExpenseSplits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Expenses') ? [] : ['className' => ExpensesTable::class];
        $this->Expenses = $this->getTableLocator()->get('Expenses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Expenses);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ExpensesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ExpensesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
