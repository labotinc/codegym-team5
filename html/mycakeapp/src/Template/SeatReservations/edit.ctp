<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SeatReservation $seatReservation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $seatReservation->member_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $seatReservation->member_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Seat Reservations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="seatReservations form large-9 medium-8 columns content">
    <?= $this->Form->create($seatReservation) ?>
    <fieldset>
        <legend><?= __('Edit Seat Reservation') ?></legend>
        <?php
            echo $this->Form->control('is_cancelled');
            echo $this->Form->control('created_at');
            echo $this->Form->control('updated_at');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
