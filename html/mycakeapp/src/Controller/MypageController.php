<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Utility\Security;
use Cake\Core\Configure;

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
        $this->loadModel('Creditcards');
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
        $reserved = null;
        //現在以降にログインユーザーが予約している情報を抽出
        $reservedLists = $this->Payments->find('ReservedLists', ['memberId' => $memberId]);
        //ログインユーザーが予約している情報をスケジュールごとに分け、連想配列を作成
        $i = '0';
        $j = 0;
        foreach ($reservedLists as $reservedList) {
            $detailContents =  array(
                'movieTitle' => $reservedList->schedule->movie->name,
                'moviePictureName' => $reservedList->schedule->movie->picture_name,
                'date' => $reservedList->schedule->start_date->format('n月j日'),
                'week' => $week[$reservedList->schedule->start_date->format('w')],
                'startTime' => $reservedList->schedule->start_date->format('G:i'),
                'finishTime' => date('G:i', strtotime('+' . $reservedList->schedule->movie->screening_time . 'minute', strtotime($reservedList->schedule->start_date))),
                'column_number' => $reservedList->column_number,
                'record_number' => $reservedList->record_number,
                'payment' => $reservedList->purchase_price,
                'scheduleId' => $reservedList->schedule_id
            );
            $detail = $detailContents;
            if ($reservedList->reservation_detail->discount_id !== 0) {
                $discount = $this->Discounts->get($reservedList->reservation_detail->discount_id);
                $detail['discountName'] = $discount->name;
            }
            if ($reservedList->schedule_id === $i) {
                $reserved[$j][] = $detail;
                unset($detail);
            } elseif ($reservedList->schedule_id !== $i) {
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
        $memberId = $this->Auth->user('id');
        $scheduleId = $this->request->query['id'];
        $column = $this->request->query['column'];
        $record = $this->request->query['record'];
        $mainKey = [
            'member_id' => $memberId,
            'schedule_id' => $scheduleId,
            'column_number' => $column,
            'record_number' => $record,
            'is_cancelled' => 0,
        ];
        //開発者ツールによるid及びテキストを変更し、ユーザーが予約している情報以外の値を入力した時にエラーへ遷移させる。
        //偶然開発者ツールの変更によりログインユーザーが予約していた別の映画情報を合致した時は考慮しない。
        $loginUserPayments = $this->Payments->find('ReservedLists', ['memberId' => $memberId]);
        foreach ($loginUserPayments as $loginUserPayment) {
            $reservedSchedule[] = $loginUserPayment->schedule_id;
            $reservedColumn[] = $loginUserPayment->column_number;
            $reservedRecord[] = $loginUserPayment->record_number;
        }
        $isScheduleIdExist = in_array($scheduleId, $reservedSchedule);
        $isColumnExist = in_array($column, $reservedColumn);
        $isRecordExist = in_array($record, $reservedRecord);
        if ($isScheduleIdExist === false || $isColumnExist === false || $isRecordExist === false || !($this->Payments->exists($mainKey))) {
            return $this->redirect(['controller' => 'error']);
        }
        //各テーブルの該当箇所を抽出
        $payment = $this->Payments->find('ApplyEntity', ['mainKey' => $mainKey]);
        $reservationDetail = $this->ReservationDetails->find('ApplyEntity', ['mainKey' => $mainKey]);
        $seatReservation = $this->SeatReservations->find('ApplyEntity', ['mainKey' => $mainKey]);
        //予約によって付与されたポイント
        $plusPoint = $this->Points->find('ApplyPointEntity', ['mainKey' => $mainKey, 'is_minus' => 0]);
        //予約時に使用したポイント
        $minusPoint = $this->Points->find('ApplyPointEntity', ['mainKey' => $mainKey, 'is_minus' => 1]);
        //ポイントを使用していた場合は使用分のポイントをmembersテーブルに戻す
        if (!empty($plusPoint[0]) || !empty($minusPoint[0])) {
            $member = $this->Members->get($memberId);
        }
        if (!empty($plusPoint[0])) {
            $member['total_point'] -= $plusPoint[0]['point'];
            $plusPoint[0]['is_cancelled'] = 1;
            if (!($this->Points->save($plusPoint[0]))) {
                return $this->redirect(['controller' => 'error']);
            }
        }
        if (!empty($minusPoint[0])) {
            $member['total_point'] += $minusPoint[0]['point'];
            $minusPoint[0]['is_cancelled'] = 1;
            if (!($this->Points->save($minusPoint[0]))) {
                return $this->redirect(['controller' => 'error']);
            }
        }
        if (!empty($plusPoint[0]) || !empty($minusPoint[0])) {
            if (!($this->Members->save($member))) {
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
    public function checkpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $memberId = $this->Auth->user('id');
        $cardsInfoOwn = $this->Creditcards->find('CardsInfoOwn', ['memberId' => $memberId]);
        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        foreach ((array)$cardsInfoOwn as $key => $value) {
            $lastFourDigits = substr($value['card_number'], -4, 4);
            $encryptedCardId = Security::encrypt($value['id'], $securityKey, $securitySalt);
            $cardsInfoOwn[$key]['card_number'] = $lastFourDigits;
            $cardsInfoOwn[$key]['id'] = $encryptedCardId;
        }
        $title = '決済情報';
        $this->set(compact('title', 'cardsInfoOwn'));
    }
    public function addpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $entity = $this->Creditcards->newEntity();
        $memberId = $this->Auth->user('id');
        $cardsInfoOwn = $this->Creditcards->find('CardsInfoOwn', ['memberId' => $memberId]);
        if (!empty($this->request->query['id'])) { //updateの$entity
            // 暗号化したクレジットカードIDを戻す
            $securityKey = Configure::read('key');
            $securitySalt = Configure::read('salt');
            $encryptedCardId = $this->request->query['id'];
            $cardId = Security::decrypt($encryptedCardId, $securityKey, $securitySalt);
            if ($cardId === false) { //不正なIDの時
                return $this->redirect(['controller' => 'error']);
            }
            foreach ((array)$cardsInfoOwn as $cardInfoOwn) {
                if ($cardInfoOwn['id'] === (int)$cardId) {
                    $cardHolderIsMember = true;
                }
            }
            if (empty($cardHolderIsMember)) { //カードがユーザーのものじゃない時
                return $this->redirect(['controller' => 'error']);
            }
            $entity = $this->Creditcards->get($cardId);
            $previousCardNumber = $entity['card_number'];
        } else { //insertのカード数判定
            $numberOfCardsOwned = count($cardsInfoOwn);
            if ($numberOfCardsOwned === 2) {
                return $this->redirect(['controller' => 'error']);
            }
        }
        if (!empty($this->request->is('Put'))) { //update
            $entity = $this->Creditcards->patchEntity($entity, $this->request->getData());

            $isCardNumberExist = in_array($entity['card_number'], $this->Creditcards->find('AllCardNumbers'), true);
            if ($isCardNumberExist === true && $entity['card_number'] !== $previousCardNumber) {
                $cardNumberIsNotUnique = "このクレジットカードは利用できません";
                $this->set(compact('cardNumberIsNotUnique'));
            } else {
                $entity["updated_at"] = date("Y/m/d H:i:s");
                if (empty($cardNumberIsNotUnique) && $this->Creditcards->save($entity)) {
                    $_SESSION['addedpayment'] = 1;
                    return $this->redirect(['action' => 'addedpayment']);
                }
            }
        }
        if (!empty($this->request->is('post'))) { //insert
            $entity = $this->Creditcards->patchEntity($entity, $this->request->getData());
            $isCardNumberExist = in_array($entity['card_number'], $this->Creditcards->find('AllCardNumbers'), true);
            if ($isCardNumberExist === true) {
                $cardNumberIsNotUnique = "このクレジットカードは利用できません";
                $this->set(compact('cardNumberIsNotUnique'));
            } else {
                $entity["member_id"] = $this->Auth->user('id');
                $entity["is_deleted"] = 0;
                $entity["created_at"] = date("Y/m/d H:i:s");
                $entity["updated_at"] = date("Y/m/d H:i:s");
                if ($this->Creditcards->save($entity) && empty($cardNumberIsNotUnique)) {
                    $_SESSION['addedpayment'] = 1;
                    return $this->redirect(['action' => 'addedpayment']);
                }
            }
        }
        $title = "決済情報";
        $this->set(compact('entity', 'title'));
    }
    public function addedpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        if (empty($_SESSION['addedpayment'])) {
            return $this->redirect(['controller' => 'error']);
        }
        $this->request->session()->delete('addedpayment');
        $title = "決済情報";
        $this->set(compact('title'));
    }
    public function deletepayment()
    {
        $this->viewBuilder()->setLayout('frame-no-title');

        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        $encryptedCardId = $this->request->query['id'];
        $cardId = Security::decrypt($encryptedCardId, $securityKey, $securitySalt);

        if ($cardId === false) { //不正なIDの時
            return $this->redirect(['controller' => 'error']);
        }
        $memberId = $this->Auth->user('id');
        $cardsInfoOwn = $this->Creditcards->find('CardsInfoOwn', ['memberId' => $memberId]);
        foreach ((array)$cardsInfoOwn as $cardInfoOwn) {
            if ($cardInfoOwn['id'] === (int)$cardId) {
                $cardHolderIsMember = true;
            }
        }
        if (!($cardHolderIsMember)) {
            return $this->redirect(['controller' => 'error']);
        }

        $entity = $this->Creditcards->get($cardId);
        $entity['is_deleted'] = 1;
        if (!($this->Creditcards->save($entity))) {
            return $this->redirect(['controller' => 'error']);
        }
        $_SESSION['deletedpayment'] = 1;
        return $this->redirect(['action' => 'deletedpayment']);
    }
    public function deletedpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        if (empty($_SESSION['deletedpayment'])) {
            return $this->redirect(['controller' => 'error']);
        }
        $this->request->session()->delete('deletedpayment');
        $title = "決済情報";
        $this->set(compact('title'));
    }
}
