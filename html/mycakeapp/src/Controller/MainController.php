<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;
use Exception;

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

  public function schedule()
  {
    $week = ['日', '月', '火', '水', '木', '金', '土'];
    $today = Time::now();
    for ($i = 0; $i < 7; $i++) {
      $date = Time::now();
      $dates[$i] = $date->addDays($i);
    }
    $movies = $this->Movies->find()
      ->where(['Movies.started_at <=' => $today])
      ->andWhere(['Movies.finished_at >=' => $today])
      ->andWhere(['Movies.is_deleted' => 0])
      ->order(['Movies.started_at' => 'desc'])
      ->contain('Schedules', function ($q) use ($today) {
        return $q->where(['Schedules.start_date >=' => $today->format('Y-m-d 00:00:00')])
          ->andWhere(['Schedules.start_date <=' => $today->format('Y-m-d 23:59:59')])
          ->andWhere(['Schedules.is_deleted' => 0])
          ->order(['Schedules.start_date' => 'asc']);
      });
    $this->set(compact('dates', 'week', 'movies', 'today'));
  }
}
