<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SlideshowPicture $slideshowPicture
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $slideshowPicture->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $slideshowPicture->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Slideshow Pictures'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Movies'), ['controller' => 'Movies', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Movie'), ['controller' => 'Movies', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="slideshowPictures form large-9 medium-8 columns content">
    <?= $this->Form->create($slideshowPicture) ?>
    <fieldset>
        <legend><?= __('Edit Slideshow Picture') ?></legend>
        <?php
            echo $this->Form->control('movie_id', ['options' => $movies]);
            echo $this->Form->control('picture_name');
            echo $this->Form->control('started_at');
            echo $this->Form->control('finished_at');
            echo $this->Form->control('is_deleted');
            echo $this->Form->control('created_at');
            echo $this->Form->control('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
