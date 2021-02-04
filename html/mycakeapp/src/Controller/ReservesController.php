<?php

namespace App\Controller;

use App\Controller\AppController;

class ReservesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Schedules');
        $this->loadModel('SeatReservations');
        $this->loadModel('ReservationDetails');
        $this->loadModel('Fees');
        $this->loadModel('Discounts');
        $member = $this->Auth->user();
        if (empty($member) && $this->request->action !== 'seat') {
            return $this->redirect(['controller' => 'error']);
        }
    }

    public function seat()
    {
        if (!empty($_SESSION['seat'])) { //ticketアクションから戻ってきたときにキャンセルフラグを立てる
            $seatReservation = $this->SeatReservations->find()
                ->where([
                    'member_id' => $_SESSION['seat']['member_id'],
                    'schedule_id' => $_SESSION['seat']['schedule_id'],
                    'column_number' => $_SESSION['seat']['column_number'],
                    'record_number' => $_SESSION['seat']['record_number'],
                ])
                ->toArray();
            $seatReservation[0]['is_cancelled'] = '1';
            if (!($this->SeatReservations->save($seatReservation['0']))) {
                return $this->redirect(['controller' => 'error']);
            }
            $this->request->session()->delete('seat');
        }
    }

    public function ticket()
    {
        //座席予約から以下の4つの項目が渡されている前提(座席確保機能完成時に消す)
        $_SESSION['seat']['member_id'] = 1;
        $_SESSION['seat']['schedule_id'] = 1;
        $_SESSION['seat']['column_number'] = 'A';
        $_SESSION['seat']['record_number'] = 1;

        //URL直打ち対策
        if (empty($_SESSION['seat'])) {
            return $this->redirect(['controller' => 'error']);
        }
        $this->viewBuilder()->setLayout('frame-title');
        $title = 'チケット種別';
        $schedule = $this->Schedules->get($_SESSION['seat']['schedule_id'], ['contain' => ['Movies']]);
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        //映画情報及び座席情報をdetail変数に代入(viewへの呼び出す変数をまとめるため)
        $detail['movieTitle'] = $schedule->movie->name;
        $detail['date'] = $schedule->start_date->format('n月j日');
        $detail['week'] = $week[$schedule->start_date->format('w')];
        $detail['startTime'] = $schedule->start_date->format('G:i');
        $detail['finishTime'] = date('G:i', strtotime('+' . $schedule->movie->screening_time . 'minute', strtotime($schedule->start_date)));
        $detail['seatColumn'] = $_SESSION['seat']['column_number'];
        $detail['seatRecord'] = $_SESSION['seat']['record_number'];
        //基本料金情報を抽出
        $tickets = $this->Fees->find()
            ->where([
                'started_at <=' => $schedule->start_date,
                'OR' => [['finished_at >=' => $schedule->start_date], ['finished_at IS NULL']],
                'is_deleted' => 0,
            ])
            ->order(['fee' => 'desc'])
            ->toArray();
        //取得した基本料金情報のID配列を作成(後々の照合用)
        foreach ($tickets as $ticket) {
            $ticketId[] = $ticket->id;
        }
        if ($this->request->is('post')) {
            if (empty($this->request->data['detail'])) { //何も選択しない状態で送信した時
                $error = '※チケット種別を選択してください';
                $this->set(compact('error'));
            }
            if (!empty($this->request->data['detail']) && in_array($this->request->data['detail'], $ticketId)) {
                $_SESSION['schedule'] = $schedule;
                $_SESSION['detail'] = $detail;
                $_SESSION['detail']['fee_id'] = $this->request->data['detail'];
                return $this->redirect(['controller' => 'reserves', 'action' => 'discount']);
            } elseif (!empty($this->request->data['detail']) && !(in_array($this->request->data['detail'], $ticketId))) { //開発者ツールにて$ticketId以外の値に変更して送信した時
                return $this->redirect(['controller' => 'error']);
            }
        }
        $this->set(compact('title', 'detail', 'tickets'));
    }

    public function discount()
    {
        //URL直打ち対策
        if (!(isset($_SESSION['detail']['fee_id']))) {
            return $this->redirect(['controller' => 'error']);
        }
        $this->viewBuilder()->setLayout('frame-title');
        $title = '割引';
        $schedule = $_SESSION['schedule'];
        $feeTicket = $this->Fees->get($_SESSION['detail']['fee_id']);
        $detail = $_SESSION['detail'];
        //割引情報の抽出(全員対象の割引)
        $discounts['everyone'] = $this->Discounts->find()
            ->where([
                'started_at <=' => $schedule->start_date,
                'OR' => [['finished_at >=' => $schedule->start_date], ['finished_at IS NULL']],
                'is_everyone' => 1,
                'is_deleted' => 0,
            ])
            ->toArray();
        //割引情報の抽出(全員対象ではない割引)
        $discounts['notEveryone'] = $this->Discounts->find()
            ->where([
                'started_at <=' => $schedule->start_date,
                'OR' => [['finished_at >=' => $schedule->start_date], ['finished_at IS NULL']],
                'is_everyone' => 0,
                'is_deleted' => 0,
            ])
            ->toArray();
        if ($this->request->is('post')) {
            $_SESSION['detail']['discount_id'] = $this->request->data['discount'];
            $_SESSION['fee'] = $feeTicket;
            return $this->redirect(['controller' => 'reserves', 'action' => 'checkdetail']);
        }
        $this->set(compact('title', 'detail', 'discounts', 'schedule', 'feeTicket'));
    }

    public function checkdetail()
    {
        //直接画面遷移の対応
        if (!(isset($_SESSION['detail']['discount_id']))) {
            return $this->redirect(['controller' => 'error']);
        }
        $this->viewBuilder()->setLayout('frame-title');
        $detail = $_SESSION['detail'];
        $feeTicket = $_SESSION['fee'];
        $title = '予約確認';
        if ($_SESSION['detail']['discount_id'] !== '0') { //該当なしを選択していない場合
            $discountTicket = $this->Discounts->get($_SESSION['detail']['discount_id']);
        }
        if (!empty($discountTicket) && (int)$discountTicket->is_minus === 1) {
            $detail['discountName'] = $discountTicket->name;
            $detail['amountOfMoney'] = $feeTicket->fee - $discountTicket->displayed_amount;
            if ($detail['amountOfMoney'] < 0) {
                $detail['amountOfMoney'] = 0;
            }
        } elseif (!empty($discountTicket) && (int)$discountTicket->is_minus === 0) {
            $detail['discountName'] = $discountTicket->name;
            $detail['amountOfMoney'] = $discountTicket->displayed_amount;
        } else {
            $detail['discountName'] = '該当なし';
            $detail['amountOfMoney'] = $feeTicket->fee;
        }
        if ($this->request->is('post')) {
            $entity = $this->ReservationDetails->newEntity();
            $entity["member_id"] = $_SESSION['seat']['member_id'];
            $entity["schedule_id"] = $_SESSION['seat']['schedule_id'];
            $entity["column_number"] = $_SESSION['seat']['column_number'];
            $entity["record_number"] = $_SESSION['seat']['record_number'];
            $entity["fee_id"] = $_SESSION['detail']['fee_id'];
            $entity["discount_id"] = $_SESSION['detail']['discount_id'];
            $entity["is_cancelled"] = 0;
            $entity["created_at"] = date("Y/m/d H:i:s");
            $entity["updated_at"] = date("Y/m/d H:i:s");
            if ($this->ReservationDetails->save($entity)) {
                $this->request->session()->delete('seat');
                $this->request->session()->delete('schedule');
                $this->request->session()->delete('detail');
                $this->request->session()->delete('fee');
                $_SESSION['reservationDetails'] = 1; //paymentの直接画面遷移対策でセッション作成
                return $this->redirect(['action' => 'payment']);
            } else {
                return $this->redirect(['controller' => 'error']);
            }
        }
        $this->set(compact('title', 'detail', 'feeTicket'));
    }
}
