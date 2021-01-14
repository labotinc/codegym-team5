<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PointRate $pointRate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Point Rate'), ['action' => 'edit', $pointRate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Point Rate'), ['action' => 'delete', $pointRate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pointRate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Point Rates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Point Rate'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pointRates view large-9 medium-8 columns content">
    <h3><?= h($pointRate->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($pointRate->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pointRate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Point Rate') ?></th>
            <td><?= $this->Number->format($pointRate->point_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started At') ?></th>
            <td><?= h($pointRate->started_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finished At') ?></th>
            <td><?= h($pointRate->finished_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($pointRate->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($pointRate->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $pointRate->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
