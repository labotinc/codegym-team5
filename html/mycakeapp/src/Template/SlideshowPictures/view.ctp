<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SlideshowPicture $slideshowPicture
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Slideshow Picture'), ['action' => 'edit', $slideshowPicture->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Slideshow Picture'), ['action' => 'delete', $slideshowPicture->id], ['confirm' => __('Are you sure you want to delete # {0}?', $slideshowPicture->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Slideshow Pictures'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Slideshow Picture'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Movies'), ['controller' => 'Movies', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Movie'), ['controller' => 'Movies', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="slideshowPictures view large-9 medium-8 columns content">
    <h3><?= h($slideshowPicture->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Movie') ?></th>
            <td><?= $slideshowPicture->has('movie') ? $this->Html->link($slideshowPicture->movie->name, ['controller' => 'Movies', 'action' => 'view', $slideshowPicture->movie->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Picture Name') ?></th>
            <td><?= h($slideshowPicture->picture_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($slideshowPicture->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Started At') ?></th>
            <td><?= h($slideshowPicture->started_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Finished At') ?></th>
            <td><?= h($slideshowPicture->finished_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($slideshowPicture->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($slideshowPicture->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $slideshowPicture->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
