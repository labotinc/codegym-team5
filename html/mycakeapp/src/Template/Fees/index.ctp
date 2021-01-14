<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Fee[]|\Cake\Collection\CollectionInterface $fees
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Fee'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reservation Details'), ['controller' => 'ReservationDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation Detail'), ['controller' => 'ReservationDetails', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fees index large-9 medium-8 columns content">
    <h3><?= __('Fees') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fee') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finished_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fees as $fee): ?>
            <tr>
                <td><?= $this->Number->format($fee->id) ?></td>
                <td><?= h($fee->name) ?></td>
                <td><?= $this->Number->format($fee->fee) ?></td>
                <td><?= h($fee->started_at) ?></td>
                <td><?= h($fee->finished_at) ?></td>
                <td><?= h($fee->is_deleted) ?></td>
                <td><?= h($fee->created_at) ?></td>
                <td><?= h($fee->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $fee->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fee->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $fee->id)]) ?>
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
