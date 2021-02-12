<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Creditcard $creditcard
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Creditcard'), ['action' => 'edit', $creditcard->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Creditcard'), ['action' => 'delete', $creditcard->id], ['confirm' => __('Are you sure you want to delete # {0}?', $creditcard->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Creditcards'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Creditcard'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Members'), ['controller' => 'Members', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Member'), ['controller' => 'Members', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Payments'), ['controller' => 'Payments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Payment'), ['controller' => 'Payments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="creditcards view large-9 medium-8 columns content">
    <h3><?= h($creditcard->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Member') ?></th>
            <td><?= $creditcard->has('member') ? $this->Html->link($creditcard->member->id, ['controller' => 'Members', 'action' => 'view', $creditcard->member->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Card Number') ?></th>
            <td><?= h($creditcard->card_number) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($creditcard->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($creditcard->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Deadline') ?></th>
            <td><?= h($creditcard->deadline) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created At') ?></th>
            <td><?= h($creditcard->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Updated At') ?></th>
            <td><?= h($creditcard->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $creditcard->is_deleted ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Payments') ?></h4>
        <?php if (!empty($creditcard->payments)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Member Id') ?></th>
                <th scope="col"><?= __('Schedule Id') ?></th>
                <th scope="col"><?= __('Creditcard Id') ?></th>
                <th scope="col"><?= __('Is Cancelled') ?></th>
                <th scope="col"><?= __('Created At') ?></th>
                <th scope="col"><?= __('Updated At') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($creditcard->payments as $payments): ?>
            <tr>
                <td><?= h($payments->member_id) ?></td>
                <td><?= h($payments->schedule_id) ?></td>
                <td><?= h($payments->creditcard_id) ?></td>
                <td><?= h($payments->is_cancelled) ?></td>
                <td><?= h($payments->created_at) ?></td>
                <td><?= h($payments->updated_at) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->member_id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->member_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->member_id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->member_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
