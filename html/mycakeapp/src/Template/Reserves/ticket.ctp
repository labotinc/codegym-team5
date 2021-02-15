<?php echo $this->Html->css('ticket'); ?>
<div class="movie-detail">
  <p class="movie-title"><?= $detail['movieTitle'] ?></p>
  <p class="movie-time"><?= $detail['date'] . '(' . $detail['week'] . ')' . $detail['startTime'] . '~' . $detail['finishTime'] ?></p>
  <p class="seatNum">座席：<?= $detail['seatColumn'] . '-' . $detail['seatRecord'] ?></p>
</div>
<?php echo $this->Form->create(null, ['novalidate' => true, 'class' => 'flex ticket-form']); ?>
<?php foreach ($tickets as $ticket) : ?>
  <label class="ticketDetail" for="<?= $ticket['id'] ?>">
    <?php echo $this->Form->radio('detail', [['text' => $ticket['name'], 'value' => $ticket['id'], 'id' => $ticket['id']]], ['hiddenField' => false]); ?>
    <p><?= $this->Number->format($ticket['fee']) ?>円</p>
  </label>
<?php endforeach; ?>
<?php if (!empty($notSelectError)) : ?>
  <p class="error"><?= $notSelectError ?></p>
<?php endif; ?>
<div class="half-button">
  <?php
  echo $this->Form->button('戻る', ['onclick' => 'history.back()', 'class' => 'button back-gray', 'type' => 'button']);
  echo $this->Form->button('次へ', ['class' => 'button back-orange']);
  ?>
</div>
<?php echo $this->Form->end(); ?>
