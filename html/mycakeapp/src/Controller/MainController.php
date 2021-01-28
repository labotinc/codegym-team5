<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;

class MainController extends AppController
{
  public $useTable = false;

  public function initialize()
  {
    parent::initialize();
    $this->loadModel('Movies');
    $this->loadModel('SlideshowPictures');
    $this->loadModel('Schedules');
    $this->loadModel('Discounts');
    $this->loadModel('Fees');
  }

  public function schedule($id = null)
  {
    $this->viewBuilder()->setLayout('no-frame');
    if ($id) { //予約購入ボタンを押した場合
      session_start();
      $_SESSION['schedule_id'] = $id;
      return $this->redirect(['controller' => 'reserves', 'action' => 'seat']);
    }
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
    // 指定した日(今は$today)から7日の日時を配列に代入
    for ($i = 0; $i < 7; $i++) {
      $date = Time::now();
      $dates[$i]['date'] = $date->addDays($i);
      $dates[$i]['num'] = $i;
    }
    $this->set(compact('dates', 'week', 'movies', 'today'));
  }

  public function ajax()
  {
    if ($this->request->is('ajax')) { //ajax通信で呼び出されたら
      $recieved_data = $this->request->query['date']; //JavaScriptから送られてきたデータを受け取る
      $day = Time::now()->addDays($recieved_data);
      $selectMovies = $this->Movies->find()
        ->where(['started_at <=' => $day])
        ->andWhere(['finished_at >=' => $day])
        ->andWhere(['is_deleted' => 0])
        ->order(['started_at' => 'desc'])
        ->contain('Schedules', function ($q) use ($day) {
          return $q->where(['start_date >=' => $day->format('Y-m-d 00:00:00')])
            ->andWhere(['start_date <=' => $day->format('Y-m-d 23:59:59')])
            ->andWhere(['is_deleted' => 0])
            ->order(['start_date' => 'asc']);
        });
      return $this->getResponse()->withType('json')->withStringBody(json_encode(
        $selectMovies,
      ));
    }
  }

  public function top()
  {
    $this->viewBuilder()->setLayout('no-frame');
    $today = Time::now();
    //条件に当てはまるスライドショーを抽出(条件は基本設計書参照)
    $slideshowPictures = $this->SlideshowPictures->find()
      ->contain(['Movies'])
      ->where([
        'SlideshowPictures.started_at <=' => $today,
        'SlideshowPictures.finished_at >=' => $today,
        'SlideshowPictures.is_deleted' => 0,
        'Movies.is_deleted' => 0
      ])
      ->order(['Movies.started_at' => 'desc'])
      ->limit(3)
      ->toArray();
    //条件に当てはまる上映映画一覧画像を抽出
    $moviePictures = $this->Movies->find()
      ->where([
        'started_at <=' => $today,
        'finished_at >=' => $today,
        'is_deleted' => 0,
        'top_picture_name IS NOT NULL'
      ])
      ->order(['started_at' => 'desc'])
      ->toArray();
    //条件に当てはまる割引画像を表示
    $discountPictures = $this->Discounts->find()
      ->where([
        'started_at <=' => $today,
        'OR' => [['finished_at >=' => $today], ['finished_at IS NULL']],
        'is_deleted' => 0
      ])
      ->order(['started_at' => 'desc'])
      ->toArray();
    $this->set(compact('slideshowPictures', 'moviePictures', 'discountPictures'));
  }
  public function price()
  {
    $this->viewBuilder()->setLayout('no-frame');
    $today = Time::now()->format('Y-m-d H:i:s');
    $fees = $this->Fees->find()->select(['name', 'fee'])
      ->where([
        'is_deleted' => 0,
        'started_at <=' => $today,
        'finished_at >=' => $today,
      ])
      ->order(['fee' => 'desc'])
      ->toArray();

    // 生のSQL文実行
    $connection = ConnectionManager::get('default');
    // 例)$highestFee-discount_amount=最大割引額
    $highestFee = $fees[0]->fee;
    $max_discount_amount = $highestFee . '-discount_amount as max_discount_amount';
    $where = [
      "is_deleted = 0",
      'started_at <= "' . $today . '"',
      'finished_at >= "' . $today . '"'
    ];
    $andWhere = ' AND ' . $where[0] . ' AND ' . $where[1] . ' AND ' . $where[2];
    $maxDiscountsSql = "SELECT $max_discount_amount,detail,name FROM Discounts WHERE discount_amount>=1000 $andWhere";
    $discountsSql = "SELECT discount_amount,detail,name FROM Discounts WHERE discount_amount<1000 $andWhere";

    $maxDiscountsResult = $connection->execute($maxDiscountsSql . ' ORDER BY discount_amount desc')->fetchAll('assoc');
    $discountsResult = $connection->execute($discountsSql . ' ORDER BY discount_amount desc')->fetchAll('assoc');

    $this->set(compact('fees', 'maxDiscountsResult', 'discountsResult'));
  }
}
