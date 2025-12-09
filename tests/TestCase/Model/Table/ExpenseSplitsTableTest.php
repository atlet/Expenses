<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExpenseSplitsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExpenseSplitsTable Test Case
 */
class ExpenseSplitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExpenseSplitsTable
     */
    protected $ExpenseSplits;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ExpenseSplits',
        'app.Expenses',
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
        $config = $this->getTableLocator()->exists('ExpenseSplits') ? [] : ['className' => ExpenseSplitsTable::class];
        $this->ExpenseSplits = $this->getTableLocator()->get('ExpenseSplits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ExpenseSplits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ExpenseSplitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ExpenseSplitsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
