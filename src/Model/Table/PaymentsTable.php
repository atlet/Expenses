<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PaymentsTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('payments');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('FromPerson', [
            'className' => 'People',
            'foreignKey' => 'from_person_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ToPerson', [
            'className' => 'People',
            'foreignKey' => 'to_person_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->decimal('amount')
            ->requirePresence('amount', 'create')
            ->notEmptyString('amount')
            ->greaterThan('amount', 0);

        $validator
            ->date('payment_date')
            ->requirePresence('payment_date', 'create')
            ->notEmptyDate('payment_date');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        return $validator;
    }
}
