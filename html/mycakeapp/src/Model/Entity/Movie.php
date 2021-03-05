<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movie Entity
 *
 * @property int $id
 * @property string $name
 * @property int $screening_time
 * @property string $picture_name
 * @property string|null $top_picture_name
 * @property \Cake\I18n\Time $started_at
 * @property \Cake\I18n\Time $finished_at
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\Schedule[] $schedules
 * @property \App\Model\Entity\SlideshowPicture[] $slideshow_pictures
 */
class Movie extends Entity
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
        'screening_time' => true,
        'picture_name' => true,
        'top_picture_name' => true,
        'started_at' => true,
        'finished_at' => true,
        'is_deleted' => true,
        'created_at' => true,
        'updated_at' => true,
        'schedules' => true,
        'slideshow_pictures' => true,
    ];
}
