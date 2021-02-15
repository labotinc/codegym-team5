<?php echo $this->Html->css('checkdetail'); ?>
<div class="movie-detail">
  <p class="sub-detail"><?= $detail['movieTitle'] ?></p>
  <p class="sub-detail"><?= $detail['date'] . '(' . $detail['week'] . ')' . $detail['startTime'] . '~' . $detail['finishTime'] ?></p>
  <p class="sub-detail">座席：<?= $detail['seatColumn'] . '-' . $detail['seatRecord'] ?></p>
  <p class="sub-detail">種別：<?= $feeTicket->name ?></p>
  <p class="sub-detail">割引：<?= $detail['discountName'] ?></p>
  <p class="sub-detail">金額：<?= $this->Number->format($detail['amountOfMoney']) ?>円</p>
</div>
<?php echo $this->Form->create(null, ['novalidate' => true, 'class' => 'flex ticket-form']); ?>
<div class="half-button">
  <?php
  echo $this->Form->button('戻る', ['onclick' => 'history.back()', 'class' => 'button back-gray', 'type' => 'button']);
  echo $this->Form->button('決済へ', ['class' => 'button back-orange']);
  ?>
</div>
<?php echo $this->Form->end(); ?>
