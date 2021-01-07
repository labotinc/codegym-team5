<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PointRate[]|\Cake\Collection\CollectionInterface $pointRates
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Point Rate'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pointRates index large-9 medium-8 columns content">
    <h3><?= __('Point Rates') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('point_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finished_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pointRates as $pointRate): ?>
            <tr>
                <td><?= $this->Number->format($pointRate->id) ?></td>
                <td><?= h($pointRate->name) ?></td>
                <td><?= $this->Number->format($pointRate->point_rate) ?></td>
                <td><?= h($pointRate->started_at) ?></td>
                <td><?= h($pointRate->finished_at) ?></td>
                <td><?= h($pointRate->is_deleted) ?></td>
                <td><?= h($pointRate->created_at) ?></td>
                <td><?= h($pointRate->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $pointRate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pointRate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pointRate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pointRate->id)]) ?>
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
