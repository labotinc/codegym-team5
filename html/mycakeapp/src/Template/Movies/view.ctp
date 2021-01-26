<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Movie $movie
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Movie'), ['action' => 'edit', $movie->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Movie'), ['action' => 'delete', $movie->id], ['confirm' => __('Are you sure you want to delete # {0}?', $movie->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Movies'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movie'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Slideshow Pictures'), ['controller' => 'SlideshowPictures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Slideshow Picture'), ['controller' => 'SlideshowPictures', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="movies view large-9 medium-8 columns content">
    <h3><?= h($movie->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($movie->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Picture Name') ?></th>
            <td><?= h($movie->picture_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Top Picture Name') ?></th>
            <td><?= h($movie->top_picture_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($movie->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Screening Time') ?></th>
            <td><?= $this->Number->format($movie->screening_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started At') ?></th>
            <td><?= h($movie->started_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finished At') ?></th>
            <td><?= h($movie->finished_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($movie->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($movie->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $movie->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Schedules') ?></h4>
        <?php if (!empty($movie->schedules)): ?>
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
            <?php foreach ($movie->schedules as $schedules): ?>
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
    <div class="related">
        <h4><?= __('Related Slideshow Pictures') ?></h4>
        <?php if (!empty($movie->slideshow_pictures)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Movie Id') ?></th>
                <th scope="col"><?= __('Picture Name') ?></th>
                <th scope="col"><?= __('Started At') ?></th>
                <th scope="col"><?= __('Finished At') ?></th>
                <th scope="col"><?= __('Is Deleted') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($movie->slideshow_pictures as $slideshowPictures): ?>
            <tr>
                <td><?= h($slideshowPictures->id) ?></td>
                <td><?= h($slideshowPictures->movie_id) ?></td>
                <td><?= h($slideshowPictures->picture_name) ?></td>
                <td><?= h($slideshowPictures->started_at) ?></td>
                <td><?= h($slideshowPictures->finished_at) ?></td>
                <td><?= h($slideshowPictures->is_deleted) ?></td>
                <td><?= h($slideshowPictures->created_at) ?></td>
                <td><?= h($slideshowPictures->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'SlideshowPictures', 'action' => 'view', $slideshowPictures->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'SlideshowPictures', 'action' => 'edit', $slideshowPictures->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'SlideshowPictures', 'action' => 'delete', $slideshowPictures->id], ['confirm' => __('Are you sure you want to delete # {0}?', $slideshowPictures->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
