<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Creditcards'), ['controller' => 'Creditcards', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Creditcard'), ['controller' => 'Creditcards', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="payments index large-9 medium-8 columns content">
    <h3><?= __('Payments') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('member_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('schedule_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('creditcard_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('column_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('record_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('purchase_price') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_cancelled') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
            <tr>
                <td><?= $payment->has('member') ? $this->Html->link($payment->member->id, ['controller' => 'Members', 'action' => 'view', $payment->member->id]) : '' ?></td>
                <td><?= $payment->has('schedule') ? $this->Html->link($payment->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $payment->schedule->id]) : '' ?></td>
                <td><?= $payment->has('creditcard') ? $this->Html->link($payment->creditcard->name, ['controller' => 'Creditcards', 'action' => 'view', $payment->creditcard->id]) : '' ?></td>
                <td><?= h($seatReservation->column_number) ?></td>
                <td><?= h($seatReservation->record_number) ?></td>
                <td><?= h($payment->purchase_price) ?></td>
                <td><?= h($payment->is_cancelled) ?></td>
                <td><?= h($payment->created_at) ?></td>
                <td><?= h($payment->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $payment->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $payment->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $payment->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->member_id)]) ?>
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
