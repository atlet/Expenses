<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ExpenseCategoriesTable extends Table {
    public function initialize(array $config): void {
        parent::initialize($config);

        $this->setTable('expense_categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Expenses', [
            'foreignKey' => 'expense_category_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('name_en')
            ->maxLength('name_en', 100)
            ->requirePresence('name_en', 'create')
            ->notEmptyString('name_en');

        $validator
            ->scalar('color')
            ->maxLength('color', 7)
            ->notEmptyString('color');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 50)
            ->allowEmptyString('icon');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        return $validator;
    }

    /**
     * Vrne prevedeno ime kategorije glede na trenutni locale
     */
    public function getTranslatedName($category): string {
        $locale = \Cake\I18n\I18n::getLocale();
        return $locale === 'en_US' ? $category->name_en : $category->name;
    }
}
