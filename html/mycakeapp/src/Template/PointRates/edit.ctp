<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PointRate $pointRate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pointRate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pointRate->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Point Rates'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="pointRates form large-9 medium-8 columns content">
    <?= $this->Form->create($pointRate) ?>
    <fieldset>
        <legend><?= __('Edit Point Rate') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('point_rate');
            echo $this->Form->control('started_at');
            echo $this->Form->control('finished_at', ['empty' => true]);
            echo $this->Form->control('is_deleted');
            echo $this->Form->control('created_at');
            echo $this->Form->control('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
