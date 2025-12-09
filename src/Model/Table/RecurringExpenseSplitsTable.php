<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RecurringExpenseSplits Model
 *
 * @property \App\Model\Table\RecurringExpensesTable&\Cake\ORM\Association\BelongsTo $RecurringExpenses
 * @property \App\Model\Table\PeopleTable&\Cake\ORM\Association\BelongsTo $People
 *
 * @method \App\Model\Entity\RecurringExpenseSplit newEmptyEntity()
 * @method \App\Model\Entity\RecurringExpenseSplit newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\RecurringExpenseSplit> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RecurringExpenseSplit get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\RecurringExpenseSplit findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\RecurringExpenseSplit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\RecurringExpenseSplit> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\RecurringExpenseSplit|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\RecurringExpenseSplit saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\RecurringExpenseSplit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecurringExpenseSplit>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecurringExpenseSplit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecurringExpenseSplit> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecurringExpenseSplit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecurringExpenseSplit>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\RecurringExpenseSplit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\RecurringExpenseSplit> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RecurringExpenseSplitsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('recurring_expense_splits');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('RecurringExpenses', [
            'foreignKey' => 'recurring_expense_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('People', [
            'foreignKey' => 'person_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('recurring_expense_id')
            ->notEmptyString('recurring_expense_id');

        $validator
            ->integer('person_id')
            ->notEmptyString('person_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['recurring_expense_id', 'person_id']), ['errorField' => 'recurring_expense_id']);
        $rules->add($rules->existsIn(['recurring_expense_id'], 'RecurringExpenses'), ['errorField' => 'recurring_expense_id']);
        $rules->add($rules->existsIn(['person_id'], 'People'), ['errorField' => 'person_id']);

        return $rules;
    }
}
