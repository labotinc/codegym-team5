<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeatReservation $seatReservation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Seat Reservation'), ['action' => 'edit', $seatReservation->member_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Seat Reservation'), ['action' => 'delete', $seatReservation->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $seatReservation->member_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Seat Reservations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Seat Reservation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="seatReservations view large-9 medium-8 columns content">
    <h3><?= h($seatReservation->member_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Member') ?></th>
            <td><?= $seatReservation->has('member') ? $this->Html->link($seatReservation->member->id, ['controller' => 'Members', 'action' => 'view', $seatReservation->member->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule') ?></th>
            <td><?= $seatReservation->has('schedule') ? $this->Html->link($seatReservation->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $seatReservation->schedule->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Column Number') ?></th>
            <td><?= h($seatReservation->column_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Record Number') ?></th>
            <td><?= h($seatReservation->record_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($seatReservation->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($seatReservation->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Cancelled') ?></th>
            <td><?= $seatReservation->is_cancelled ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
