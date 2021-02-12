<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

class MypageController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Members');
        $this->loadModel('Payments');
        $this->loadModel('Schedules');
        $this->loadModel('Movies');
        $this->loadModel('ReservationDetails');
        $this->loadModel('SeatReservations');
        $this->loadModel('Discounts');
        $this->loadModel('Points');
        $member = $this->Auth->user();
        if (empty($member)) {
            return $this->redirect(['controller' => 'error']);
        }
    }

    public function top()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $id = $this->Auth->user('id');
        $loginMember = $this->Members->findById($id)->toArray();
        $title = 'マイページ';
        $this->set(compact('title', 'loginMember'));
    }
    public function delete()
    {
        //削除ボタンを押さない限りエラー画面へ遷移する
        if (empty($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] !== 'http://localhost:10380/mypage/top') {
            return $this->redirect(['controller' => 'error']);
        }
        $this->viewBuilder()->setLayout('frame-no-title');
        $id = $this->Auth->user('id');
        $entity = $this->Members->get($id);
        $entity['is_deleted'] = 1;
        if (!($this->Members->save($entity))) {
            return $this->redirect(['controller' => 'error']);
        }
        //ログアウト後はdeletedアクションへ遷移させる
        $_SESSION['deleted'] = 1;
        $this->Auth->logout();
        return $this->redirect(['controller' => 'members', 'action' => 'deleted']);
    }

    public function reserved()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $memberId = $this->Auth->user('id');
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        $today = Time::now();
        $reserved = null;
        //現在以降にログインユーザーが予約している情報を抽出
        $reservedLists = $this->Payments->find()
            ->contain(['Schedules'])
            ->where([
                'Payments.member_id' => $memberId,
                'Payments.is_cancelled' => 0,
                'Schedules.start_date >' => $today,
                'Schedules.is_deleted' => 0
            ])
            ->order([
                'Schedules.start_date' => 'DESC',
                'Payments.schedule_id' => 'ASC',
                'Payments.column_number' => 'ASC',
                'Payments.record_number' => 'ASC',
            ])
            ->toArray();
        //ログインユーザーが予約している情報をスケジュールごとに分け、連想配列を作成
        $i = '0';
        $j = 0;
        foreach ($reservedLists as $reservedList) {
            $mainKey = [
                'member_id' => $memberId,
                'schedule_id' => $reservedList->schedule_id,
                'column_number' => $reservedList->column_number,
                'record_number' => $reservedList->record_number,
            ];
            if ($reservedList->schedule_id === $i) {
                $movieDetail = $this->Schedules->find()
                    ->contain(['Movies'])
                    ->where(['Schedules.id' => $reservedList->schedule_id])
                    ->toArray();
                $reservationDetail = $this->ReservationDetails->find()
                    ->where($mainKey)
                    ->toArray();
                if (empty($reservationDetail) && empty($movieDetail)) {
                    return $this->redirect(['controller' => 'error']);
                }
                $detail = array(
                    'movieTitle' => $movieDetail[0]->movie->name,
                    'moviePictureName' => $movieDetail[0]->movie->picture_name,
                    'date' => $movieDetail[0]->start_date->format('n月j日'),
                    'week' => $week[$movieDetail[0]->start_date->format('w')],
                    'startTime' => $movieDetail[0]->start_date->format('G:i'),
                    'finishTime' => date('G:i', strtotime('+' . $movieDetail[0]->movie->screening_time . 'minute', strtotime($movieDetail[0]->start_date))),
                    'column_number' => $reservedList->column_number,
                    'record_number' => $reservedList->record_number,
                    'payment' => $reservedList->purchase_price,
                    'scheduleId' => $reservedList->schedule_id
                );
                if ($reservationDetail[0]->discount_id !== 0) {
                    $discount = $this->Discounts->get($reservationDetail[0]->discount_id);
                    $detail['discountName'] = $discount->name;
                }
                $reserved[$j][] = $detail;
                unset($detail);
            } elseif ($reservedList->schedule_id !== $i) {
                $movieDetail = $this->Schedules->find()
                    ->contain(['Movies'])
                    ->where(['Schedules.id' => $reservedList->schedule_id])
                    ->toArray();
                $reservationDetail = $this->ReservationDetails->find()
                    ->where($mainKey)
                    ->toArray();
                if (empty($reservationDetail) && empty($movieDetail)) {
                    return $this->redirect(['controller' => 'error']);
                }
                $detail = array(
                    'movieTitle' => $movieDetail[0]->movie->name,
                    'moviePictureName' => $movieDetail[0]->movie->picture_name,
                    'date' => $movieDetail[0]->start_date->format('n月j日'),
                    'week' => $week[$movieDetail[0]->start_date->format('w')],
                    'startTime' => $movieDetail[0]->start_date->format('G:i'),
                    'finishTime' => date('G:i', strtotime('+' . $movieDetail[0]->movie->screening_time . 'minute', strtotime($movieDetail[0]->start_date))),
                    'column_number' => $reservedList->column_number,
                    'record_number' => $reservedList->record_number,
                    'payment' => $reservedList->purchase_price,
                    'scheduleId' => $reservedList->schedule_id
                );
                if ($reservationDetail[0]->discount_id !== 0) {
                    $discount = $this->Discounts->get($reservationDetail[0]->discount_id);
                    $detail['discountName'] = $discount->name;
                }
                $j++;
                $reserved[$j][] = $detail;
                unset($detail);
                $i = $reservedList->schedule_id;
            }
        }
        $title = '予約詳細';
        $this->set(compact('title', 'reserved'));
    }

    public function canceled()
    {
        $this->viewBuilder()->setLayout('frame-no-title');
        //URL直打ち対策
        if (empty($this->referer(null, true)) || $this->referer(null, true) !== '/mypage/reserved') {
            return $this->redirect(['controller' => 'error']);
        }
        $today = Time::now();
        $memberId = $this->Auth->user('id');
        $scheduleId = $this->request->query['id'];
        $column = $this->request->query['column'];
        $record = $this->request->query['record'];
        //開発者ツールによるid及びテキストを変更し、ユーザーが予約している情報以外の値を入力した時にエラーへ遷移させる。
        //偶然開発者ツールの変更によりログインユーザーが予約していた別の映画情報を合致した時は考慮しない。
        $loginUserPayments = $this->Payments->find()
            ->contain(['Schedules'])
            ->where([
                'Payments.member_id' => $memberId,
                'Payments.is_cancelled' => 0,
                'Schedules.start_date >' => $today
            ])
            ->toArray();
        foreach ($loginUserPayments as $loginUserPayment) {
            $reservedSchedule[] = $loginUserPayment->schedule_id;
            $reservedColumn[] = $loginUserPayment->column_number;
            $reservedRecord[] = $loginUserPayment->record_number;
        }
        $isScheduleIdExist = in_array($scheduleId, $reservedSchedule);
        $isColumnExist = in_array($column, $reservedColumn);
        $isRecordExist = in_array($record, $reservedRecord);
        if ($isScheduleIdExist === false || $isColumnExist === false || $isRecordExist === false) {
            return $this->redirect(['controller' => 'error']);
        }
        //各テーブルの該当箇所を抽出
        $mainKey = [
            'member_id' => $memberId,
            'schedule_id' => $scheduleId,
            'column_number' => $column,
            'record_number' => $record,
            'is_cancelled' => 0,
        ];
        $payment = $this->Payments->find()
            ->where($mainKey)
            ->toArray();
        $reservationDetail = $this->ReservationDetails->find()
            ->where($mainKey)
            ->toArray();
        $seatReservation = $this->SeatReservations->find()
            ->where($mainKey)
            ->toArray();
        $point = $this->Points->find()
            ->where($mainKey)
            ->toArray();
        //ポイントを使用していた場合は使用分のポイントをmembersテーブルに戻す
        if (!empty($point[0])) {
            $member = $this->Members->get($memberId);
            $member['total_point'] -= $point[0]['point'];
            $point[0]['is_cancelled'] = 1;
            if (!($this->Members->save($member)) || !($this->Points->save($point[0]))) {
                return $this->redirect(['controller' => 'error']);
            }
        }
        //該当テーブルのキャンセルフラグを立てる
        $payment[0]['is_cancelled'] = 1;
        $reservationDetail[0]['is_cancelled'] = 1;
        $seatReservation[0]['is_cancelled'] = 1;
        if (!($this->Payments->save($payment[0])) || !($this->ReservationDetails->save($reservationDetail[0])) || !($this->SeatReservations->save($seatReservation[0]))) {
            return $this->redirect(['controller' => 'error']);
        }
    }
}
