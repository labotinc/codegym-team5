<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tax $tax
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Taxes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="taxes form large-9 medium-8 columns content">
    <?= $this->Form->create($tax) ?>
    <fieldset>
        <legend><?= __('Add Tax') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('tax_rate');
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
