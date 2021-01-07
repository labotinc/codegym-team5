<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReservationDetail $reservationDetail
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Reservation Detail'), ['action' => 'edit', $reservationDetail->member_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Reservation Detail'), ['action' => 'delete', $reservationDetail->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservationDetail->member_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Reservation Details'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation Detail'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fees'), ['controller' => 'Fees', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fee'), ['controller' => 'Fees', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Discounts'), ['controller' => 'Discounts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Discount'), ['controller' => 'Discounts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="reservationDetails view large-9 medium-8 columns content">
    <h3><?= h($reservationDetail->member_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Member') ?></th>
            <td><?= $reservationDetail->has('member') ? $this->Html->link($reservationDetail->member->id, ['controller' => 'Members', 'action' => 'view', $reservationDetail->member->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule') ?></th>
            <td><?= $reservationDetail->has('schedule') ? $this->Html->link($reservationDetail->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $reservationDetail->schedule->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Column Number') ?></th>
            <td><?= h($reservationDetail->column_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Record Number') ?></th>
            <td><?= h($reservationDetail->record_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fee') ?></th>
            <td><?= $reservationDetail->has('fee') ? $this->Html->link($reservationDetail->fee->name, ['controller' => 'Fees', 'action' => 'view', $reservationDetail->fee->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Discount') ?></th>
            <td><?= $reservationDetail->has('discount') ? $this->Html->link($reservationDetail->discount->name, ['controller' => 'Discounts', 'action' => 'view', $reservationDetail->discount->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($reservationDetail->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($reservationDetail->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Cancelled') ?></th>
            <td><?= $reservationDetail->is_cancelled ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
