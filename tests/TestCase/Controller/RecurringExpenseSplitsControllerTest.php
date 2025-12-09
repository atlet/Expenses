<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\RecurringExpenseSplitsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\RecurringExpenseSplitsController Test Case
 *
 * @link \App\Controller\RecurringExpenseSplitsController
 */
class RecurringExpenseSplitsControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
     * Test index method
     *
     * @return void
     * @link \App\Controller\RecurringExpenseSplitsController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @link \App\Controller\RecurringExpenseSplitsController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @link \App\Controller\RecurringExpenseSplitsController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @link \App\Controller\RecurringExpenseSplitsController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @link \App\Controller\RecurringExpenseSplitsController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
