<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Creditcard Entity
 *
 * @property int $id
 * @property int $member_id
 * @property varbinary $card_number
 * @property string $name
 * @property string $deadline
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Payment[] $payments
 */
class Creditcard extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'member_id' => true,
        'card_number' => true,
        'name' => true,
        'deadline' => true,
        'is_deleted' => true,
        'created_at' => true,
        'updated_at' => true,
        'member' => true,
        'payments' => true,
    ];
}
