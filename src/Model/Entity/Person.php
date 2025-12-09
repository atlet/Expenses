<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Person Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\ExpenseSplit[] $expense_splits
 * @property \App\Model\Entity\RecurringExpenseSplit[] $recurring_expense_splits
 */
class Person extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'email' => true,
        'created' => true,
        'modified' => true,
        'expense_splits' => true,
        'recurring_expense_splits' => true,
    ];
}
