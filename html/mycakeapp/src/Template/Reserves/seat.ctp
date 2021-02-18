<?= $this->HTML->css('seat') ?>
<?php
$startdate = $seatDetails['start_date'];
$finishdate = date('G:i', strtotime('+' . $seatDetails['movie']['screening_time'] . 'minute', strtotime($startdate)));
?>
<div class="seat_heading">
    <h1><?= $seatDetails['movie']['name']; ?></h1>
    <h2><?= $startdate->format('m月d日 G:i') ?>〜<span><?= $finishdate ?></span></h2>
</div><!-- /.seat_heading -->
<div class="seat_select">
    <?= $this->element('Theater/' . $seatDetails['theater']['file_name']); ?>
</div><!-- /.seat_select -->
<button class="normal-button back-orange"><?= $this->HTML->link('次へ', ['action' => 'seat']) ?></button>
