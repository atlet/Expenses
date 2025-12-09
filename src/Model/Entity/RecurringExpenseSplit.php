<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * RecurringExpenseSplit Entity
 *
 * @property int $id
 * @property int $recurring_expense_id
 * @property int $person_id
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\RecurringExpense $recurring_expense
 * @property \App\Model\Entity\Person $person
 */
class RecurringExpenseSplit extends Entity
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
        'recurring_expense_id' => true,
        'person_id' => true,
        'created' => true,
        'recurring_expense' => true,
        'person' => true,
    ];
}
