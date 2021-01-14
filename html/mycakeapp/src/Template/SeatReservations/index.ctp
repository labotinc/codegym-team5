<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeatReservation[]|\Cake\Collection\CollectionInterface $seatReservations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Seat Reservation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="seatReservations index large-9 medium-8 columns content">
    <h3><?= __('Seat Reservations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('member_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('column_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('record_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_cancelled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($seatReservations as $seatReservation): ?>
            <tr>
                <td><?= $seatReservation->has('member') ? $this->Html->link($seatReservation->member->id, ['controller' => 'Members', 'action' => 'view', $seatReservation->member->id]) : '' ?></td>
                <td><?= $seatReservation->has('schedule') ? $this->Html->link($seatReservation->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $seatReservation->schedule->id]) : '' ?></td>
                <td><?= h($seatReservation->column_number) ?></td>
                <td><?= h($seatReservation->record_number) ?></td>
                <td><?= h($seatReservation->is_cancelled) ?></td>
                <td><?= h($seatReservation->created_at) ?></td>
                <td><?= h($seatReservation->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $seatReservation->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $seatReservation->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $seatReservation->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $seatReservation->member_id)]) ?>
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
