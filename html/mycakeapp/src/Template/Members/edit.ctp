<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Member $member
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $member->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $member->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Members'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Creditcards'), ['controller' => 'Creditcards', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Creditcard'), ['controller' => 'Creditcards', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Points'), ['controller' => 'Points', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Point'), ['controller' => 'Points', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Reservation Details'), ['controller' => 'ReservationDetails', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Reservation Detail'), ['controller' => 'ReservationDetails', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Seat Reservations'), ['controller' => 'SeatReservations', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Seat Reservation'), ['controller' => 'SeatReservations', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="members form large-9 medium-8 columns content">
    <?= $this->Form->create($member) ?>
    <fieldset>
        <legend><?= __('Edit Member') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('total_point');
            echo $this->Form->control('is_deleted');
            echo $this->Form->control('is_provisional');
            echo $this->Form->control('created_at');
            echo $this->Form->control('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
