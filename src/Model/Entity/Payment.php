<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $from_person_id
 * @property int $to_person_id
 * @property string $amount
 * @property \Cake\I18n\Date $payment_date
 * @property string|null $notes
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Person $from_person
 * @property \App\Model\Entity\Person $to_person
 */
class Payment extends Entity
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
        'from_person_id' => true,
        'to_person_id' => true,
        'amount' => true,
        'payment_date' => true,
        'notes' => true,
        'created' => true,
        'modified' => true,
        'from_person' => true,
        'to_person' => true,
    ];
}
