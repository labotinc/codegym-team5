<?php echo $this->Html->css('checkpayment(reserve'); ?>
<div class="sub-total">
    <div class="flex">
        <p>チケット金額</p>
        <p>¥<?php echo h($this->Number->format($fee)); ?></p>
    </div>
    <?php if (!empty($discountName)) : ?>
        <div class="flex reduction">
            <p><?php echo h($discountName); ?></p>
            <p>¥<?php echo h($this->Number->format($displayedAmount)); ?></p>
        </div>
    <?php endif; ?>
    <div class="flex reduction">
        <p>ご利用ポイント</p>
        <p><?php echo h($usePoint); ?>pt</p>
    </div>
    <div class="divider"></div>
    <div class="flex">
        <p>小計</p>
        <p>¥<?php echo h($this->Number->format($subTotal)); ?></p>
    </div>
    <div class="flex">
        <p>消費税</p>
        <p>¥<?php echo h($this->Number->format($tax)); ?></p>
    </div>
    <div class="divider"></div>
    <div class="flex">
        <p>合計(税込み)</p>
        <p>¥<?php echo h($this->Number->format($purchasePrice)); ?></p>
    </div>
</div>
<div class="flex division-button">
    <?php
    echo $this->Html->link('戻る', ['action' => 'payment'], ['class' => 'button normal-button back-gray']);
    echo $this->Form->postLink('決済', '#', ['class' => 'button normal-button back-orange']);
    ?>
</div>
