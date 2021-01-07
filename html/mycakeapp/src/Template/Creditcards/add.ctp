<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Creditcard $creditcard
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Creditcards'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="creditcards form large-9 medium-8 columns content">
    <?= $this->Form->create($creditcard) ?>
    <fieldset>
        <legend><?= __('Add Creditcard') ?></legend>
        <?php
            echo $this->Form->control('member_id', ['options' => $members]);
            echo $this->Form->control('card_number');
            echo $this->Form->control('name');
            echo $this->Form->control('deadline');
            echo $this->Form->control('is_deleted');
            echo $this->Form->control('created_at');
            echo $this->Form->control('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
