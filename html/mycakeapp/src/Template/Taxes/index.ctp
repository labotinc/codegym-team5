<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tax[]|\Cake\Collection\CollectionInterface $taxes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tax'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="taxes index large-9 medium-8 columns content">
    <h3><?= __('Taxes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tax_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finished_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($taxes as $tax): ?>
            <tr>
                <td><?= $this->Number->format($tax->id) ?></td>
                <td><?= h($tax->name) ?></td>
                <td><?= $this->Number->format($tax->tax_rate) ?></td>
                <td><?= h($tax->started_at) ?></td>
                <td><?= h($tax->finished_at) ?></td>
                <td><?= h($tax->is_deleted) ?></td>
                <td><?= h($tax->created_at) ?></td>
                <td><?= h($tax->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tax->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tax->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tax->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tax->id)]) ?>
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
