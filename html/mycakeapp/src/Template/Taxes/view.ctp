<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tax $tax
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tax'), ['action' => 'edit', $tax->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tax'), ['action' => 'delete', $tax->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tax->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Taxes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tax'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="taxes view large-9 medium-8 columns content">
    <h3><?= h($tax->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($tax->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tax->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tax Rate') ?></th>
            <td><?= $this->Number->format($tax->tax_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started At') ?></th>
            <td><?= h($tax->started_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finished At') ?></th>
            <td><?= h($tax->finished_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($tax->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($tax->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $tax->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
