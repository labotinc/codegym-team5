<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Theater $theater
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Theater'), ['action' => 'edit', $theater->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Theater'), ['action' => 'delete', $theater->id], ['confirm' => __('Are you sure you want to delete # {0}?', $theater->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Theaters'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Theater'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="theaters view large-9 medium-8 columns content">
    <h3><?= h($theater->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($theater->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('File Name') ?></th>
            <td><?= h($theater->file_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($theater->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($theater->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($theater->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $theater->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Schedules') ?></h4>
        <?php if (!empty($theater->schedules)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Movie Id') ?></th>
                <th scope="col"><?= __('Theater Id') ?></th>
                <th scope="col"><?= __('Start Date') ?></th>
                <th scope="col"><?= __('Is Deleted') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($theater->schedules as $schedules): ?>
            <tr>
                <td><?= h($schedules->id) ?></td>
                <td><?= h($schedules->movie_id) ?></td>
                <td><?= h($schedules->theater_id) ?></td>
                <td><?= h($schedules->start_date) ?></td>
                <td><?= h($schedules->is_deleted) ?></td>
                <td><?= h($schedules->created_at) ?></td>
                <td><?= h($schedules->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Schedules', 'action' => 'view', $schedules->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Schedules', 'action' => 'edit', $schedules->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Schedules', 'action' => 'delete', $schedules->id], ['confirm' => __('Are you sure you want to delete # {0}?', $schedules->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
