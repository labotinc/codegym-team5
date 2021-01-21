<?= $this->HTML->css('schedule') ?>
<h1 class="mainTitle">上映スケジュール</h1>
<ul class="dateList">
  <?php foreach ($dates as $date) : ?>
    <li class="dateListContent" value="<?= $date['num']?>">
      <p class="date"><?= h($date['date']->format('n月j日') . '(' . $week[$date['date']->format('w')] . ')'); ?></p>
      <?php if ($date['date']->format('j') === '1') : ?>
        <p class="discountInfo">ファーストデイ割引</p>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>
<h2 class="selectDate"><?= h($today->format('n月j日') . '(' . $week[$today->format('w')] . ')'); ?></h2>
<ul id="movieList">
  <?php foreach ($movies as $movie) : ?>
    <?php if (!empty($movie['schedules'])) : ?>
      <li class="movieListContent">
        <div class="movieDetail">
          <div class="movieDetailList">
            <p class="title"><?= h($movie->name) ?></p>
            <p class="screeningTime">[上映時間 : <?= h($movie->screening_time) ?>分]</p>
            <p class="finishDate"><?= h($movie->finished_at->format('n月j日') . '(' . $week[$movie->finished_at->format('w')] . ')終了予定');  ?></p>
          </div>
        </div>
        <div class="movieSchedule">
          <p class="movieImage"><?= $this->Html->image('movies/' . h($movie->picture_name)) ?></p>
          <ul class="scheduleList">
            <?php foreach ($movie['schedules'] as $schedule) : ?>
              <li class="scheduleListContent">
                <div class="scheduleTime">
                  <p class="startTime"><?= h($schedule->start_date->format('G:i')) ?></p>
                  <p class="mark">〜</p>
                  <p class="finishTime"><?= h(date('G:i', strtotime('+' . $movie->screening_time . 'minute', strtotime($schedule->start_date)))) ?></p>
                </div>
                <?php if ($schedule->start_date > $today) : ?>
                  <p class="reservationButton"><a href="<?= $this->Url->build(['action' => 'schedule', $schedule->id]) ?>">予約購入</a></p>
                <?php elseif ($schedule->start_date <= $today) : ?>
                  <p class="nonReservationButton">購入不可</p>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </li>
    <?php endif; ?>
  <?php endforeach; ?>
</ul>
<?= $this->HTML->script('jquery.min')?>
<?= $this->HTML->script('schedule')?>
