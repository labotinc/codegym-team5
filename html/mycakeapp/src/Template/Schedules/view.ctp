<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Schedule $schedule
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Schedule'), ['action' => 'edit', $schedule->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Schedule'), ['action' => 'delete', $schedule->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schedule->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movies'), ['controller' => 'Movies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movie'), ['controller' => 'Movies', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Theaters'), ['controller' => 'Theaters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Theater'), ['controller' => 'Theaters', 'action' => 'add']) ?> </li>
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
<div class="schedules view large-9 medium-8 columns content">
    <h3><?= h($schedule->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Movie') ?></th>
            <td><?= $schedule->has('movie') ? $this->Html->link($schedule->movie->name, ['controller' => 'Movies', 'action' => 'view', $schedule->movie->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Theater') ?></th>
            <td><?= $schedule->has('theater') ? $this->Html->link($schedule->theater->name, ['controller' => 'Theaters', 'action' => 'view', $schedule->theater->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($schedule->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Start Date') ?></th>
            <td><?= h($schedule->start_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($schedule->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($schedule->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $schedule->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Payments') ?></h4>
        <?php if (!empty($schedule->payments)): ?>
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
            <?php foreach ($schedule->payments as $payments): ?>
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
        <?php if (!empty($schedule->points)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Schedule Id') ?></th>
                <th scope="col"><?= __('Point') ?></th>
                <th scope="col"><?= __('Is Cancelled') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($schedule->points as $points): ?>
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
        <?php if (!empty($schedule->reservation_details)): ?>
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
            <?php foreach ($schedule->reservation_details as $reservationDetails): ?>
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
        <?php if (!empty($schedule->seat_reservations)): ?>
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
            <?php foreach ($schedule->seat_reservations as $seatReservations): ?>
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
