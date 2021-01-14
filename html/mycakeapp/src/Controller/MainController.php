<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class MainController extends AppController
{
  public $useTable = false;

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('Movies');
    $this->loadModel('Schedules');
    $this->loadModel('Discounts');
  }

  public function movieSchedule()
  {
    $week = ['日', '月', '火', '水', '木', '金', '土'];
    $today = Time::now();
    //指定した日(今は$today)が映画の上映期間内で、かつ指定した日の上映スケジュールを抽出
    $movies = $this->Movies->find()
      ->where(['started_at <=' => $today])
      ->andWhere(['finished_at >=' => $today])
      ->andWhere(['is_deleted' => 0])
      ->order(['started_at' => 'desc'])
      ->contain('Schedules', function ($q) use ($today) {
        return $q->where(['start_date >=' => $today->format('Y-m-d 00:00:00')])
          ->andWhere(['start_date <=' => $today->format('Y-m-d 23:59:59')])
          ->andWhere(['is_deleted' => 0])
          ->order(['start_date' => 'asc']);
      });
    //指定した日(今は$today)から7日の日時を配列に代入
    for ($i = 0; $i < 7; $i++) {
      $date = Time::now();
      $dates[$i] = $date->addDays($i);
    }
    $this->set(compact('dates', 'week', 'movies', 'today'));
  }
}
