<?php echo $this->Html->css('checkpayment'); ?>
<?php foreach ($cardsInfoOwn as $key => $cardsInfoOwn) : ?>
    <div class="flex">
        <div class="cardInfo">
            <p><?= $cardsInfoOwn['name']; ?></p>
            <p>****-****-****-<?= $cardsInfoOwn['card_number']; ?> - 有効期限 <?= date('m/y', strtotime($cardsInfoOwn['deadline'])); ?></p>
        </div>
        <div class="action">
            <p><?= $this->HTML->link('編集', ['action' => 'addpayment', 'id' => $cardsInfoOwn['id']], ['class' => 'button back-gray']) ?></p>
            <p><?= $this->HTML->link('削除', '#', ['class' => 'button back-gray delete-payment', 'id' => urlencode($cardsInfoOwn['id'])]); ?></p>
        </div>
    </div>
<?php endforeach; ?>
<div class="half-button flex">
    <?= $this->HTML->link('マイページに戻る', ['action' => 'top'], ['class' => 'button back-gray']); ?>
    <?= $this->HTML->link('新規登録', '#', ['class' => 'button back-orange add-payment', 'id' => 'add-payment']); ?>
</div>
<?= $this->HTML->script('jquery.min') ?>
<?= $this->HTML->script('checkpayment') ?>
