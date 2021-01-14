<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Schedule Entity
 *
 * @property int $id
 * @property int $movie_id
 * @property int $theater_id
 * @property \Cake\I18n\Time $start_date
 * @property bool $is_deleted
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\Movie $movie
 * @property \App\Model\Entity\Theater $theater
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Point[] $points
 * @property \App\Model\Entity\ReservationDetail[] $reservation_details
 * @property \App\Model\Entity\SeatReservation[] $seat_reservations
 */
class Schedule extends Entity
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
        'movie_id' => true,
        'theater_id' => true,
        'start_date' => true,
        'is_deleted' => true,
        'created_at' => true,
        'updated_at' => true,
        'movie' => true,
        'theater' => true,
        'payments' => true,
        'points' => true,
        'reservation_details' => true,
        'seat_reservations' => true,
    ];
}
