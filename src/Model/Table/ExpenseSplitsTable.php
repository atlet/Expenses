<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ExpenseSplitsTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('expense_splits');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => ['created' => 'new']
            ]
        ]);

        $this->belongsTo('Expenses', [
            'foreignKey' => 'expense_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('People', [
            'foreignKey' => 'person_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->decimal('share_ratio')
            ->requirePresence('share_ratio', 'create')
            ->notEmptyString('share_ratio')
            ->greaterThan('share_ratio', 0)
            ->lessThanOrEqual('share_ratio', 1);

        return $validator;
    }
}
