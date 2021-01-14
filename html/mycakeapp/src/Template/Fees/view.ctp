<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fee $fee
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Fee'), ['action' => 'edit', $fee->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Fee'), ['action' => 'delete', $fee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fee->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Fees'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fee'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Reservation Details'), ['controller' => 'ReservationDetails', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Reservation Detail'), ['controller' => 'ReservationDetails', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fees view large-9 medium-8 columns content">
    <h3><?= h($fee->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($fee->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($fee->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fee') ?></th>
            <td><?= $this->Number->format($fee->fee) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started At') ?></th>
            <td><?= h($fee->started_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finished At') ?></th>
            <td><?= h($fee->finished_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($fee->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($fee->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $fee->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Reservation Details') ?></h4>
        <?php if (!empty($fee->reservation_details)): ?>
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
            <?php foreach ($fee->reservation_details as $reservationDetails): ?>
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
</div>
