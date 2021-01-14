<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SlideshowPicture[]|\Cake\Collection\CollectionInterface $slideshowPictures
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Slideshow Picture'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Movies'), ['controller' => 'Movies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movie'), ['controller' => 'Movies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="slideshowPictures index large-9 medium-8 columns content">
    <h3><?= __('Slideshow Pictures') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('movie_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('picture_name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('started_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finished_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('is_deleted') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_at') ?></th>
                <th scope="col"><?= $this->Paginator->sort('updated_at') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($slideshowPictures as $slideshowPicture): ?>
            <tr>
                <td><?= $this->Number->format($slideshowPicture->id) ?></td>
                <td><?= $slideshowPicture->has('movie') ? $this->Html->link($slideshowPicture->movie->name, ['controller' => 'Movies', 'action' => 'view', $slideshowPicture->movie->id]) : '' ?></td>
                <td><?= h($slideshowPicture->picture_name) ?></td>
                <td><?= h($slideshowPicture->started_at) ?></td>
                <td><?= h($slideshowPicture->finished_at) ?></td>
                <td><?= h($slideshowPicture->is_deleted) ?></td>
                <td><?= h($slideshowPicture->created_at) ?></td>
                <td><?= h($slideshowPicture->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $slideshowPicture->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $slideshowPicture->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $slideshowPicture->id], ['confirm' => __('Are you sure you want to delete # {0}?', $slideshowPicture->id)]) ?>
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
