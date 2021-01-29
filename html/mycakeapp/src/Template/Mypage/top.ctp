<?php echo $this->Html->css('mypageTop'); ?>
<div class="mypageInfo">
  <div class="flex point">
    <p>ポイント</p>
    <p><?= $loginMember[0]['total_point'] ?>pt</p>
  </div>
  <div class="flex reserveInfo">
    <p>予約確認</p>
    <p><?= $this->HTML->link('詳細', ['action' => 'reserved'], ['class' => 'button select-button back-orange']) ?></p>
  </div>
  <div class="flex creditInfo">
    <p>決済情報</p>
    <p><?= $this->HTML->link('詳細', ['action' => 'checkpayment'], ['class' => 'button select-button back-orange']) ?></p>
  </div>
</div>
<div class="delete-account">
  <?= $this->Html->link('アカウントを削除', '#'); ?>
</div>
<?= $this->HTML->script('jquery.min') ?>
<?= $this->HTML->script('mypageTop') ?>
