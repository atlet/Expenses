<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExpenseSplit Entity
 *
 * @property int $id
 * @property int $expense_id
 * @property int $person_id
 * @property string $share_ratio
 * @property \Cake\I18n\DateTime $created
 *
 * @property \App\Model\Entity\Expense $expense
 * @property \App\Model\Entity\Person $person
 */
class ExpenseSplit extends Entity
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
        'expense_id' => true,
        'person_id' => true,
        'share_ratio' => true,
        'created' => true,
        'expense' => true,
        'person' => true,
    ];
}
