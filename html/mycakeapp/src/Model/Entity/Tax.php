<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tax Entity
 *
 * @property int $id
 * @property string $name
 * @property float $tax_rate
 * @property \Cake\I18n\Time $started_at
 * @property \Cake\I18n\Time|null $finished_at
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 */
class Tax extends Entity
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
        'name' => true,
        'tax_rate' => true,
        'started_at' => true,
        'finished_at' => true,
        'is_deleted' => true,
        'created_at' => true,
        'updated_at' => true,
    ];
}
