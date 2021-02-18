<?php echo $this->Html->css('reserved'); ?>
<div class="reservedList">
  <?php if (!empty($reserved)) : ?>
    <?php foreach ($reserved as $ContentsBySchedule) : ?>
      <div class="bySchedule">
        <?php foreach ($ContentsBySchedule as $ContentBySeat) : ?>
          <div class="reservedInfo">
            <p class="movieImage"><?= $this->Html->image('movies/' . $ContentBySeat['moviePictureName']) ?></p>
            <div class="movieDetail">
              <p class="movieTitle"><?= $ContentBySeat['movieTitle'] ?></p>
              <div class="movieSchedule">
                <p class="date"><?= $ContentBySeat['date'] . '(' . $ContentBySeat['week'] . ')' ?></p>
                <p class="time"><?= $ContentBySeat['startTime'] . '~' . $ContentBySeat['finishTime'] ?></p>
                <div class="seat">
                  <p class="seatColumn"><?= $ContentBySeat['column_number'] ?></p>
                  <p>-</p>
                  <p class="seatRecord"><?= $ContentBySeat['record_number'] ?></p>
                </div>
              </div>
              <div class="paymentInfo">
                <p class="fee">￥<?= $ContentBySeat['payment'] ?></p>
                <?php if (!empty($ContentBySeat['discountName'])) : ?>
                  <p class="discount"><?= $ContentBySeat['discountName'] ?></p>
                <?php endif; ?>
              </div>
            </div>
            <p class="cancel" id="<?= $ContentBySeat['scheduleId'] ?>">キャンセル</p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  <?php else : ?>
    <p>現在予約はありません。</p>
  <?php endif; ?>
</div>
<p class="backButton"><?= $this->HTML->link('マイページに戻る', ['action' => 'top'], ['class' => 'button normal-button back-orange']) ?></p>
<?= $this->HTML->script('jquery.min') ?>
<?= $this->HTML->script('reserved') ?>
