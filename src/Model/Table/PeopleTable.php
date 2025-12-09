<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PeopleTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('people');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Expenses', [
            'foreignKey' => 'paid_by_id',
        ]);
        $this->hasMany('ExpenseSplits', [
            'foreignKey' => 'person_id',
        ]);
        $this->hasMany('PaymentsFrom', [
            'className' => 'Payments',
            'foreignKey' => 'from_person_id',
        ]);
        $this->hasMany('PaymentsTo', [
            'className' => 'Payments',
            'foreignKey' => 'to_person_id',
        ]);
        $this->hasMany('RecurringExpenses', [
            'foreignKey' => 'paid_by_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->email('email')
            ->allowEmptyString('email');

        return $validator;
    }

    public function getBalances(): array {
        /** @var \Cake\Database\Connection $conn */
        $conn = $this->getConnection();

        $sql = <<<SQL
WITH stanje AS (
    SELECT
      p.id,
      p.name,
      ROUND(
        SUM(es.share_ratio * (e.amount + e.commission)),
        2
      ) AS owes,
      COALESCE(
        (
          SELECT
            ROUND(SUM(amount + commission), 2)
          FROM
            expenses
          WHERE
            paid_by_id = p.id
        ),
        0
      ) AS paid,
      (
        SELECT
          COALESCE(
            ROUND(
              SUM(ess.share_ratio * (ee.amount + ee.commission)),
              2
            ),
            0
          )
        FROM
          expenses ee
          LEFT JOIN expense_splits ess ON ess.expense_id = ee.id
        WHERE
          ee.paid_by_id = p.id
          AND ess.person_id != p.id
      ) AS terjatev,
      (
        SELECT
          COALESCE(
            ROUND(
              SUM(ess.share_ratio * (ee.amount + ee.commission)),
              2
            ),
            0
          )
        FROM
          expenses ee
          LEFT JOIN expense_splits ess ON ess.expense_id = ee.id
        WHERE
          ess.person_id = p.id
          AND ee.paid_by_id != p.id
      ) AS dolg,
      (
        SELECT
          COALESCE(ROUND(SUM(pp.amount), 2), 0)
        FROM
          payments pp
        WHERE
          pp.from_person_id = p.id
      ) AS placaldolg,
      (
        SELECT
          COALESCE(ROUND(SUM(pp.amount), 2), 0)
        FROM
          payments pp
        WHERE
          pp.to_person_id = p.id
      ) AS prejel
    FROM
      people p
      LEFT JOIN expense_splits es ON es.person_id = p.id
      LEFT JOIN expenses e ON e.id = es.expense_id
    GROUP BY
      p.id
)
SELECT 
  id,
  name,
  paid,
  owes,
  (terjatev - dolg - prejel + placaldolg) balance
FROM stanje s
SQL;

        return $conn->execute($sql)->fetchAll('assoc');
    }

    public function getNetBalances(): array {
        $conn = $this->getConnection();

        $sql = <<<SQL
WITH per_person AS (
    SELECT
        p.id,
        p.name,

        -- koliko bi morali pravično plačati
        COALESCE(
            ROUND(SUM(es.share_ratio * (e.amount + e.commission)), 2),
            0
        ) AS should_pay,

        -- koliko so dejansko plačali za stroške
        COALESCE(
            (
                SELECT ROUND(SUM(e2.amount + e2.commission), 2)
                FROM expenses e2
                WHERE e2.paid_by_id = p.id
            ), 0
        ) AS paid_expenses,

        -- koliko so plačali drugim (poravnave)
        COALESCE(
            (
                SELECT ROUND(SUM(pp.amount), 2)
                FROM payments pp
                WHERE pp.from_person_id = p.id
            ), 0
        ) AS paid_transfers,

        -- koliko so prejeli od drugih (poravnave)
        COALESCE(
            (
                SELECT ROUND(SUM(pp.amount), 2)
                FROM payments pp
                WHERE pp.to_person_id = p.id
            ), 0
        ) AS received_transfers

    FROM people p
    LEFT JOIN expense_splits es ON es.person_id = p.id
    LEFT JOIN expenses e ON e.id = es.expense_id
    GROUP BY p.id
)
SELECT
    id,
    name,
    should_pay,
    paid_expenses,
    paid_transfers,
    received_transfers,
    ROUND(
        paid_expenses - should_pay + paid_transfers - received_transfers,
        2
    ) AS net
FROM per_person
SQL;

        return $conn->execute($sql)->fetchAll('assoc');
    }

    public function getSuggestedSettlements(): array {
        $balances = $this->getNetBalances();

        $creditors = [];
        $debtors   = [];

        foreach ($balances as $row) {
            $net = (float)$row['net'];

            if ($net > 0.004) {
                $creditors[] = [
                    'id'     => (int)$row['id'],
                    'name'   => $row['name'],
                    'amount' => $net, // koliko morajo dobiti
                ];
            } elseif ($net < -0.004) {
                $debtors[] = [
                    'id'     => (int)$row['id'],
                    'name'   => $row['name'],
                    'amount' => -$net, // koliko morajo plačati
                ];
            }
        }

        // da je malo lepše, lahko sortiraš po znesku
        usort($creditors, fn($a, $b) => $b['amount'] <=> $a['amount']);
        usort($debtors,   fn($a, $b) => $b['amount'] <=> $a['amount']);

        $i = 0; // dolžniki
        $j = 0; // upniki

        $settlements = [];

        while (isset($debtors[$i]) && isset($creditors[$j])) {
            $debtor   = &$debtors[$i];
            $creditor = &$creditors[$j];

            $amount = min($debtor['amount'], $creditor['amount']);

            if ($amount <= 0.004) {
                break;
            }

            $settlements[] = [
                'from_id'   => $debtor['id'],
                'from_name' => $debtor['name'],
                'to_id'     => $creditor['id'],
                'to_name'   => $creditor['name'],
                'amount'    => round($amount, 2),
            ];

            $debtor['amount']   -= $amount;
            $creditor['amount'] -= $amount;

            if ($debtor['amount'] <= 0.004) {
                $i++;
            }
            if ($creditor['amount'] <= 0.004) {
                $j++;
            }
        }

        return $settlements;
    }
}
