<?php echo $this->Html->css('discount'); ?>
<div class="movie-detail">
  <p class="movie-title"><?= $detail['movieTitle'] ?></p>
  <p class="movie-time"><?= $detail['date'] . '(' . $detail['week'] . ')' . $detail['startTime'] . '~' . $detail['finishTime'] ?></p>
  <p class="seatNum">座席：<?= $detail['seatColumn'] . '-' . $detail['seatRecord'] ?></p>
  <p class="ticket">種別：<?= $feeTicket->name ?></p>
</div>
<?php
echo $this->Form->create(null, ['novalidate' => true, 'class' => 'flex ticket-form']);
//割引の条件や種類が変わるごとに調整する必要あり。(今回はファーストデー割引のみ適用させている)
if ($schedule->start_date->format('j') === '1') : ?>
  <label class="ticketDetail" for="<?= $discounts['everyone'][0]['id'] ?>">
    <?php echo $this->Form->radio('discount', [['text' => $discounts['everyone'][0]['name'], 'value' => $discounts['everyone'][0]['id'], 'id' => $discounts['everyone'][0]['id'], 'checked' => true]], ['hiddenField' => false]); ?>
    <?php if ((int)$discounts['everyone'][0]['is_minus'] === 1) : ?>
      <p>基本料金-<?= $this->Number->format($discounts['everyone'][0]['displayed_amount']) ?>円</p>
    <?php elseif ((int)$discounts['everyone'][0]['is_minus'] === 0) : ?>
      <p><?= $this->Number->format($discounts['everyone'][0]['displayed_amount']) ?>円</p>
    <?php endif; ?>
  </label>
<?php else : ?>
  <label class="ticketDetail" for="0">
    <?php echo $this->Form->radio('discount', [['text' => '該当なし', 'value' => '0', 'id' => '0', 'checked' => true]], ['hiddenField' => false]); ?>
    <p></p>
  </label>
  <?php
  //割引の条件や種類が変わるごとに調整する必要あり。(今回は子供女性シニア割引のみ適用させている)
  foreach ($discounts['notEveryone'] as $notEveryoneDiscount) :
    if ($notEveryoneDiscount['id'] === 2) :
  ?>
      <label class="ticketDetail" for="<?= $notEveryoneDiscount['id'] ?>">
        <?php echo $this->Form->radio('discount', [['text' => $notEveryoneDiscount['name'], 'value' => $notEveryoneDiscount['id'], 'id' => $notEveryoneDiscount['id']]], ['hiddenField' => false]); ?>
        <?php if ((int)$notEveryoneDiscount['is_minus'] === 1) : ?>
          <p>基本料金-<?= $this->Number->format($notEveryoneDiscount['displayed_amount']) ?>円</p>
        <?php elseif ((int)$notEveryoneDiscount['is_minus'] === 0) : ?>
          <p><?= $this->Number->format($notEveryoneDiscount['displayed_amount']) ?>円</p>
        <?php endif; ?>
      </label>
<?php
    endif;
  endforeach;
endif;
?>
<div class="half-button">
  <?php
  echo $this->Form->button('戻る', ['onclick' => 'history.back()', 'class' => 'button back-gray', 'type' => 'button']);
  echo $this->Form->button('確定する', ['class' => 'button back-orange']);
  ?>
</div>
<?php echo $this->Form->end(); ?>
