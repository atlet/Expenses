<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Expense Entity
 *
 * @property int $id
 * @property string $title
 * @property string $amount
 * @property string $commission
 * @property \Cake\I18n\Date $expense_date
 * @property int $paid_by_id
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Person $paid_by
 * @property \App\Model\Entity\ExpenseSplit[] $expense_splits
 */
class Expense extends Entity
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
        'title' => true,
        'amount' => true,
        'commission' => true,
        'expense_date' => true,
        'paid_by_id' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'paid_by' => true,
        'expense_splits' => true,
    ];
}
