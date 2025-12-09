<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class RecurringExpensesTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('recurring_expenses');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PaidBy', [
            'className' => 'People',
            'foreignKey' => 'paid_by_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('RecurringExpenseSplits', [
            'foreignKey' => 'recurring_expense_id',
            'dependent' => true,
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount')
            ->greaterThan('amount', 0);

        $validator
            ->decimal('commission')
            ->notEmptyString('commission');

        $validator
            ->integer('day_of_month')
            ->requirePresence('day_of_month', 'create')
            ->notEmptyString('day_of_month')
            ->range('day_of_month', [1, 28]);

        $validator
            ->date('last_added_date')
            ->allowEmptyDate('last_added_date');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        return $validator;
    }
}
