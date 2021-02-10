<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Payment'), ['action' => 'edit', $payment->member_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Payment'), ['action' => 'delete', $payment->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $payment->member_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Schedules'), ['controller' => 'Schedules', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Schedule'), ['controller' => 'Schedules', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Creditcards'), ['controller' => 'Creditcards', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Creditcard'), ['controller' => 'Creditcards', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="payments view large-9 medium-8 columns content">
    <h3><?= h($payment->member_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Member') ?></th>
            <td><?= $payment->has('member') ? $this->Html->link($payment->member->id, ['controller' => 'Members', 'action' => 'view', $payment->member->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Schedule') ?></th>
            <td><?= $payment->has('schedule') ? $this->Html->link($payment->schedule->id, ['controller' => 'Schedules', 'action' => 'view', $payment->schedule->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Creditcard') ?></th>
            <td><?= $payment->has('creditcard') ? $this->Html->link($payment->creditcard->name, ['controller' => 'Creditcards', 'action' => 'view', $payment->creditcard->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Column Number') ?></th>
            <td><?= h($reservationDetail->column_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Record Number') ?></th>
            <td><?= h($reservationDetail->record_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($payment->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($payment->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Cancelled') ?></th>
            <td><?= $payment->is_cancelled ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
