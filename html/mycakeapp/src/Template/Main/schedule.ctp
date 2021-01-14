<h1>上映スケジュール</h2>
  <ul>
    <?php foreach ($dates as $date) : ?>
      <li>
        <?= h($date->format('n月j日') . '(' . $week[$date->format('w')] . ')'); ?>
      </li>
    <?php endforeach; ?>
  </ul>
  <h2><?= h($today->format('n月j日')) ?></h2>
  <ul>
    <?php foreach ($movies as $movie) : ?>
    <?php if (!empty($movie['schedules'])){?>
      <li>
        <div>
          <p><?= h($movie->name) ?></p>
          <p>[上映時間 : <?= h($movie->screening_time) ?>分]</p>
          <p><?= h($movie->finished_at->format('n月j日') . '(' . $week[$movie->finished_at->format('w')] . ')終了予定');  ?></p>
        </div>
        <div>
          <?= $this->Html->image('movies/' . h($movie->picture_name)) ?>
          <?php foreach ($movie['schedules'] as $schedule) : ?>
            <div>
              <p><?= h($schedule->start_date->format('G:i')) ?></p>
              <p>〜</p>
              <p><?= h(date('G:i', strtotime('+' . $movie->screening_time . 'minute', strtotime($schedule->start_date)))) ?></p>
              <?php if ($schedule->start_date > $today) { ?>
                <p><a href="#">予約購入</a></p>
              <?php } elseif ($schedule->start_date <= $today) { ?>
                <p><a href="#">購入不可</a></p>
              <?php } ?>
            </div>
          <?php endforeach; ?>
        </div>
      </li>
      <?php }?>
    <?php endforeach; ?>
  </ul>
