<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ExpensesTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('expenses');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PaidBy', [
            'className' => 'People',
            'foreignKey' => 'paid_by_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ExpenseSplits', [
            'foreignKey' => 'expense_id',
            'dependent' => true,
        ]);

        $this->belongsTo('ExpenseCategories', [
            'foreignKey' => 'expense_category_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'LEFT',
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
            ->date('expense_date')
            ->requirePresence('expense_date', 'create')
            ->notEmptyDate('expense_date');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        $validator
            ->boolean('is_paid')
            ->notEmptyString('is_paid');

        $validator
            ->date('paid_date')
            ->allowEmptyDate('paid_date');

        return $validator;
    }
}
