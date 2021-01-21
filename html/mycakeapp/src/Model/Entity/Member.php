<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int $total_point
 * @property bool $is_deleted
 * @property bool $is_provisional
 * @property \Cake\I18n\Time $created_at
 * @property \Cake\I18n\Time $updated_at
 *
 * @property \App\Model\Entity\Creditcard[] $creditcards
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Point[] $points
 * @property \App\Model\Entity\ReservationDetail[] $reservation_details
 * @property \App\Model\Entity\SeatReservation[] $seat_reservations
 */
class Member extends Entity
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
        'email' => true,
        'password' => true,
        'total_point' => true,
        'is_deleted' => true,
        'is_provisional' => true,
        'created_at' => true,
        'updated_at' => true,
        'creditcards' => true,
        'payments' => true,
        'points' => true,
        'reservation_details' => true,
        'seat_reservations' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
