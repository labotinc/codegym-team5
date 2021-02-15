<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Point Entity
 *
 * @property int $member_id
 * @property int $schedule_id
 * @property string $column_number
 * @property string $record_number
 * @property int $point
 * @property bool $is_cancelled
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Schedule $schedule
 */
class Point extends Entity
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
        'schedule_id' => true,
        'column_number' => true,
        'record_number' => true,
        'point' => true,
        'is_cancelled' => true,
        'created_at' => true,
        'updated_at' => true,
        'member' => true,
        'schedule' => true,
        'is_minus' => true,
    ];
}
