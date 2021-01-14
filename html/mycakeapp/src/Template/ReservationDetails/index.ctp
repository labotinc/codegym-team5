<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ReservationDetail[]|\Cake\Collection\CollectionInterface $reservationDetails
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Reservation Detail'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Fees'), ['controller' => 'Fees', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fee'), ['controller' => 'Fees', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Discounts'), ['controller' => 'Discounts', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Discount'), ['controller' => 'Discounts', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="reservationDetails index large-9 medium-8 columns content">
    <h3><?= __('Reservation Details') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('member_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('column_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('record_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('discount_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_cancelled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservationDetails as $reservationDetail): ?>
            <tr>
                <td><?= $reservationDetail->has('member') ? $this->Html->link($reservationDetail->member->id, ['controller' => 'Members', 'action' => 'view', $reservationDetail->member->id]) : '' ?></td>
                <td><?= $reservationDetail->has('schedule') ? $this->Html->link($reservationDetail->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $reservationDetail->schedule->id]) : '' ?></td>
                <td><?= h($reservationDetail->column_number) ?></td>
                <td><?= h($reservationDetail->record_number) ?></td>
                <td><?= $reservationDetail->has('fee') ? $this->Html->link($reservationDetail->fee->name, ['controller' => 'Fees', 'action' => 'view', $reservationDetail->fee->id]) : '' ?></td>
                <td><?= $reservationDetail->has('discount') ? $this->Html->link($reservationDetail->discount->name, ['controller' => 'Discounts', 'action' => 'view', $reservationDetail->discount->id]) : '' ?></td>
                <td><?= h($reservationDetail->is_cancelled) ?></td>
                <td><?= h($reservationDetail->created_at) ?></td>
                <td><?= h($reservationDetail->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $reservationDetail->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $reservationDetail->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $reservationDetail->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $reservationDetail->member_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
