<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Creditcard[]|\Cake\Collection\CollectionInterface $creditcards
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Creditcard'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="creditcards index large-9 medium-8 columns content">
    <h3><?= __('Creditcards') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('member_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('card_number') ?></th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('deadline') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($creditcards as $creditcard): ?>
            <tr>
                <td><?= $this->Number->format($creditcard->id) ?></td>
                <td><?= $creditcard->has('member') ? $this->Html->link($creditcard->member->id, ['controller' => 'Members', 'action' => 'view', $creditcard->member->id]) : '' ?></td>
                <td><?= h($creditcard->card_number) ?></td>
                <td><?= h($creditcard->name) ?></td>
                <td><?= $this->Number->format($creditcard->deadline) ?></td>
                <td><?= h($creditcard->is_deleted) ?></td>
                <td><?= h($creditcard->created_at) ?></td>
                <td><?= h($creditcard->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $creditcard->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $creditcard->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $creditcard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditcard->id)]) ?>
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
