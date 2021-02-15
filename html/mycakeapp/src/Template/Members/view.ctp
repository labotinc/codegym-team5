<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Member $member
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Member'), ['action' => 'edit', $member->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Member'), ['action' => 'delete', $member->id], ['confirm' => __('Are you sure you want to delete # {0}?', $member->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Creditcards'), ['controller' => 'Creditcards', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Creditcard'), ['controller' => 'Creditcards', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Points'), ['controller' => 'Points', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Point'), ['controller' => 'Points', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reservation Details'), ['controller' => 'ReservationDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation Detail'), ['controller' => 'ReservationDetails', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Seat Reservations'), ['controller' => 'SeatReservations', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seat Reservation'), ['controller' => 'SeatReservations', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="members view large-9 medium-8 columns content">
    <h3><?= h($member->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Email') ?></th>
            <td><?= h($member->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($member->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($member->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Total Point') ?></th>
            <td><?= $this->Number->format($member->total_point) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($member->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($member->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $member->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Provisional') ?></th>
            <td><?= $member->is_provisional ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Creditcards') ?></h4>
        <?php if (!empty($member->creditcards)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Card Number') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Deadline') ?></th>
                <th scope="col"><?= __('Is Deleted') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($member->creditcards as $creditcards): ?>
            <tr>
                <td><?= h($creditcards->id) ?></td>
                <td><?= h($creditcards->member_id) ?></td>
                <td><?= h($creditcards->card_number) ?></td>
                <td><?= h($creditcards->name) ?></td>
                <td><?= h($creditcards->deadline) ?></td>
                <td><?= h($creditcards->is_deleted) ?></td>
                <td><?= h($creditcards->created_at) ?></td>
                <td><?= h($creditcards->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Creditcards', 'action' => 'view', $creditcards->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Creditcards', 'action' => 'edit', $creditcards->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Creditcards', 'action' => 'delete', $creditcards->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditcards->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Payments') ?></h4>
        <?php if (!empty($member->payments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Schedule Id') ?></th>
                <th scope="col"><?= __('Creditcard Id') ?></th>
                <th scope="col"><?= __('Is Cancelled') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($member->payments as $payments): ?>
            <tr>
                <td><?= h($payments->member_id) ?></td>
                <td><?= h($payments->schedule_id) ?></td>
                <td><?= h($payments->creditcard_id) ?></td>
                <td><?= h($payments->is_cancelled) ?></td>
                <td><?= h($payments->created_at) ?></td>
                <td><?= h($payments->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->member_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Points') ?></h4>
        <?php if (!empty($member->points)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Schedule Id') ?></th>
                <th scope="col"><?= __('Point') ?></th>
                <th scope="col"><?= __('Is Cancelled') ?></th>
                <th scope="col"><?= __('Is Minus') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($member->points as $points): ?>
            <tr>
                <td><?= h($points->member_id) ?></td>
                <td><?= h($points->schedule_id) ?></td>
                <td><?= h($points->point) ?></td>
                <td><?= h($points->is_cancelled) ?></td>
                <td><?= h($points->created_at) ?></td>
                <td><?= h($points->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Points', 'action' => 'view', $points->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Points', 'action' => 'edit', $points->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Points', 'action' => 'delete', $points->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $points->member_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Reservation Details') ?></h4>
        <?php if (!empty($member->reservation_details)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Schedule Id') ?></th>
                <th scope="col"><?= __('Column Number') ?></th>
                <th scope="col"><?= __('Record Number') ?></th>
                <th scope="col"><?= __('Fee Id') ?></th>
                <th scope="col"><?= __('Discount Id') ?></th>
                <th scope="col"><?= __('Is Cancelled') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($member->reservation_details as $reservationDetails): ?>
            <tr>
                <td><?= h($reservationDetails->member_id) ?></td>
                <td><?= h($reservationDetails->schedule_id) ?></td>
                <td><?= h($reservationDetails->column_number) ?></td>
                <td><?= h($reservationDetails->record_number) ?></td>
                <td><?= h($reservationDetails->fee_id) ?></td>
                <td><?= h($reservationDetails->discount_id) ?></td>
                <td><?= h($reservationDetails->is_cancelled) ?></td>
                <td><?= h($reservationDetails->created_at) ?></td>
                <td><?= h($reservationDetails->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'ReservationDetails', 'action' => 'view', $reservationDetails->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'ReservationDetails', 'action' => 'edit', $reservationDetails->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'ReservationDetails', 'action' => 'delete', $reservationDetails->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservationDetails->member_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Related Seat Reservations') ?></h4>
        <?php if (!empty($member->seat_reservations)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Schedule Id') ?></th>
                <th scope="col"><?= __('Column Number') ?></th>
                <th scope="col"><?= __('Record Number') ?></th>
                <th scope="col"><?= __('Is Cancelled') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($member->seat_reservations as $seatReservations): ?>
            <tr>
                <td><?= h($seatReservations->member_id) ?></td>
                <td><?= h($seatReservations->schedule_id) ?></td>
                <td><?= h($seatReservations->column_number) ?></td>
                <td><?= h($seatReservations->record_number) ?></td>
                <td><?= h($seatReservations->is_cancelled) ?></td>
                <td><?= h($seatReservations->created_at) ?></td>
                <td><?= h($seatReservations->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SeatReservations', 'action' => 'view', $seatReservations->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SeatReservations', 'action' => 'edit', $seatReservations->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SeatReservations', 'action' => 'delete', $seatReservations->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $seatReservations->member_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
