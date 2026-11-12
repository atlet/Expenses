<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;

class PeopleBalancesTest extends TestCase
{
    protected array $fixtures = ['app.People', 'app.Expenses', 'app.ExpenseSplits', 'app.Payments'];

    private function setupBalances(float $total, array $ratios): void
    {
        $people = $this->getTableLocator()->get('People');
        foreach ([2 => 'Borut', 3 => 'Izak'] as $id => $name) {
            $people->saveOrFail($people->newEntity(['id' => $id, 'name' => $name]));
        }
        $this->getTableLocator()->get('Expenses')->updateAll(['amount' => $total, 'commission' => 0], ['id' => 1]);
        $splits = $this->getTableLocator()->get('ExpenseSplits');
        $splits->deleteAll([]);
        foreach ($ratios as $id => $ratio) {
            $splits->saveOrFail($splits->newEntity(['expense_id' => 1, 'person_id' => $id, 'share_ratio' => $ratio]));
        }
        $this->getTableLocator()->get('Payments')->deleteAll([]);
    }

    private function transfer(int $from, float $amount): void
    {
        $payments = $this->getTableLocator()->get('Payments');
        $payments->saveOrFail($payments->newEntity([
            'from_person_id' => $from, 'to_person_id' => 1,
            'amount' => $amount, 'payment_date' => '2026-10-31',
        ]));
    }

    public function testRoundedThirdsDoNotInventDebtAfterSettlement(): void
    {
        $this->setupBalances(12000, [1 => 0.3333, 2 => 0.3333, 3 => 0.3333]);
        $this->transfer(2, 4000);
        $this->transfer(3, 4000);
        $people = $this->getTableLocator()->get('People');
        foreach ($people->getBalances() as $row) {
            $this->assertEquals(4000, $row['owes']);
            $this->assertEquals(0, $row['balance']);
        }
        $this->assertSame([], $people->getSuggestedSettlements());
    }

    public function testExplicitSharesAndTransfersHaveSameBalanceEverywhere(): void
    {
        $this->setupBalances(130.88, [1 => 43.63 / 130.88, 2 => 43.62 / 130.88, 3 => 43.63 / 130.88]);
        $this->transfer(2, 43.62);
        $this->transfer(3, 43.63);
        $people = $this->getTableLocator()->get('People');
        $net = $people->getNetBalances();
        foreach ($people->getBalances() as $index => $row) {
            $this->assertEquals(0, $row['balance']);
            $this->assertSame($net[$index]['net'], $row['balance']);
        }
        $this->assertSame([], $people->getSuggestedSettlements());
    }

    public function testActualDebtIsNotHidden(): void
    {
        $this->setupBalances(30, [1 => 0.5, 2 => 0.5]);
        $people = $this->getTableLocator()->get('People');
        $balances = array_column($people->getBalances(), 'balance', 'id');
        $this->assertEquals(15, $balances[1]);
        $this->assertEquals(-15, $balances[2]);
        $this->assertSame(15.0, $people->getSuggestedSettlements()[0]['amount']);
    }
}
