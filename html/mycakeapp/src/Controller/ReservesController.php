<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\EntityInterface;
use Cake\I18n\Time;
use App\Form\ReserveForm;
use Cake\Utility\Security;
use Cake\Core\Configure;

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
        $this->loadModel('Creditcards');
        $this->loadModel('Members');
        $this->loadModel('Payments');
        $this->loadModel('Points');
        $this->loadModel('PointRates');
        $this->loadModel('Taxes');

        $member = $this->Auth->user();
        if (empty($member) && $this->request->action !== 'seat') {
            return $this->redirect(['controller' => 'error']);
        }
    }

    public function seat()
    {
        //URL直打ち対策
        if (empty($_SESSION['schedule_id'])) {
            return $this->redirect(['controller' => 'error']);
        }
        if (!empty($_SESSION['seat'])) { //ticketアクションから戻ってきたときにキャンセルフラグを立てる
            $ExReservation = $this->SeatReservations->find()
                ->where([
                    'member_id' => $_SESSION['seat']['member_id'],
                    'schedule_id' => $_SESSION['seat']['schedule_id'],
                    'column_number' => $_SESSION['seat']['column_number'],
                    'record_number' => $_SESSION['seat']['record_number'],
                ])
                ->toArray();
            $ExReservation[0]['is_cancelled'] = '1';
            if (!($this->SeatReservations->save($ExReservation['0']))) {
                $this->request->session()->delete('seat');
                return $this->redirect(['controller' => 'error']);
            }
            $this->request->session()->delete('seat');
        }
        //席予約情報を取得
        $seatReservations = $this->SeatReservations->find()
            ->where(['schedule_id' => $_SESSION['schedule_id']])
            ->andWhere(['is_cancelled' => 0]);
        foreach ($seatReservations as $seatReservation) {
            $Reserved[] = $seatReservation['column_number'] . '-' . $seatReservation['record_number'];
        }
        //予約済み情報を取得
        $Reservations = $this->ReservationDetails->find()
            ->where(['schedule_id' => $_SESSION['schedule_id']])
            ->andWhere(['is_cancelled' => 0]);
        foreach ($Reservations as $Reservation) {
            $Reserved[] = $Reservation['column_number'] . '-' . $Reservation['record_number'];
        }
        if (isset($Reserved)) {
            $this->set(compact('Reserved'));
        }
        if ($this->request->isPost()) {
            $seatNumber = explode("-", $_POST['seat']);
            if (!empty($Reserved) && in_array($_POST['seat'], $Reserved)) {
                return $this->redirect(['controller' => 'error']);
            }
            $entity = $this->SeatReservations->newEntity();
            $entity['member_id'] = $this->Auth->user('id');
            $entity['schedule_id'] = $_SESSION['schedule_id'];
            $entity['column_number'] = $seatNumber[0];
            $entity['record_number'] = $seatNumber[1];
            $entity['is_cancelled'] = 0;
            $entity["created_at"] = date("Y/m/d H:i:s");
            $entity["updated_at"] = date("Y/m/d H:i:s");
            if ($this->SeatReservations->save($entity)) {
                $_SESSION['seat']['member_id'] = $this->Auth->user('id');
                $_SESSION['seat']['schedule_id'] = $_SESSION['schedule_id'];
                $_SESSION['seat']['column_number'] = $seatNumber[0];
                $_SESSION['seat']['record_number'] = $seatNumber[1];
                $this->redirect(['action' => 'ticket']);
            }
            $this->redirect(['controller' => 'error']);
        }
        //シアターファイル名を取得
        $seatDetails = $this->Schedules->get($_SESSION['schedule_id'], [
            'contain' => ['Movies', 'Theaters']
        ]);
        $this->viewBuilder()->setLayout('frame-title');
        $title = '座席指定';
        $week = ['日', '月', '火', '水', '木', '金', '土'];
        $startdate = $seatDetails['start_date']->format('m月d日　G:i') . '(' . $week[$seatDetails['start_date']->format('w')] . ')';
        $finishdate = date('G:i', strtotime('+' . $seatDetails['movie']['screening_time'] . 'minute', strtotime($seatDetails['start_date'])));
        $this->set(compact('title', 'seatDetails', 'startdate', 'finishdate'));
    }

    public function ticket()
    {
        //URL直打ち対策(途中でページを遷移したことによりセッションは残っていた場合も直接遷移させない)
        if (empty($_SESSION['seat']) || $this->referer(null, true) !== '/reserves/seat' && $this->referer(null, true) !== '/reserves/ticket') {
            $this->request->session()->delete('seat');
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
                $notSelectError = '※チケット種別を選択してください';
                $this->set(compact('notSelectError'));
            } else {
                $isTicketIdExist = in_array($this->request->data['detail'], $ticketId);
            }
            if (empty($notSelectError) && $isTicketIdExist === true) {
                $_SESSION['schedule'] = $schedule;
                $_SESSION['detail'] = $detail;
                $_SESSION['detail']['fee_id'] = $this->request->data['detail'];
                return $this->redirect(['controller' => 'reserves', 'action' => 'discount']);
            } elseif (empty($notSelectError) && $isTicketIdExist === false) { //開発者ツールにて$ticketId以外の値に変更して送信した時
                $this->request->session()->delete('seat');
                return $this->redirect(['controller' => 'error']);
            }
        }
        $this->set(compact('title', 'detail', 'tickets'));
    }

    public function discount()
    {
        if (!empty($_SESSION['checkdetail'])) {
            $this->request->session()->delete('checkdetail');
        }
        //URL直打ち対策(途中でページを遷移したことによりセッションは残っていた場合も直接遷移させない)
        if (!(isset($_SESSION['detail']['fee_id'])) || $this->referer(null, true) !== '/reserves/ticket' && $this->referer(null, true) !== '/reserves/discount') {
            $this->request->session()->delete('seat');
            $this->request->session()->delete('detail');
            $this->request->session()->delete('schedule');
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
        if ($schedule->start_date->format('j') === '1') {
            //取得した基本料金情報のID配列を作成(全員対象)
            foreach ($discounts['everyone'] as $everyone) {
                $discountId[] = $everyone->id;
            }
        } else {
            //取得した基本料金情報のID配列を作成(一部対象)
            foreach ($discounts['notEveryone'] as $notEveryone) {
                $discountId[] = $notEveryone->id;
            }
            $discountId[] = '0'; //該当なしの値
        }
        if ($this->request->is('post')) {
            $isTicketIdExist = in_array($this->request->data['discount'], $discountId);
            //↓今回は実装の都合上特別雨の日割引と複数人予約割引は対象から外して値を限定する。
            if ($isTicketIdExist === true && ($this->request->data['discount'] === '2' || $this->request->data['discount'] === '3' || $this->request->data['discount'] === '0')) {
                $_SESSION['detail']['discount_id'] = $this->request->data['discount'];
                $_SESSION['fee'] = $feeTicket;
                return $this->redirect(['controller' => 'reserves', 'action' => 'checkdetail']);
            } elseif ($isTicketIdExist === false) {
                $this->request->session()->delete('seat');
                $this->request->session()->delete('detail');
                $this->request->session()->delete('schedule');
                return $this->redirect(['controller' => 'error']);
            }
        }
        $this->set(compact('title', 'detail', 'discounts', 'schedule', 'feeTicket'));
    }

    public function checkdetail()
    {
        $memberId = $this->Auth->user('id');
        if (!empty($_SESSION['checkdetail'])) {
            $mainKey = [
                'member_id' => $memberId,
                'schedule_id' => $_SESSION['payment']['schedule_id'],
                'column_number' => $_SESSION['payment']['column_number'],
                'record_number' => $_SESSION['payment']['record_number'],
            ];
            $reservationDetails = $this->ReservationDetails->find('ReservationDetails', ['mainKey' => $mainKey]);
            $reservationDetails[0]['is_cancelled'] = 1;
            if (!($this->ReservationDetails->save($reservationDetails[0]))) {
                $this->request->session()->delete('seat');
                return $this->redirect(['controller' => 'error']);
            }
            $movieDetails = $this->Schedules->find('MovieDetails', ['schedule_id' => $reservationDetails[0]['schedule_id']]);
            $_SESSION['detail'] = [
                'movieTitle' => $movieDetails->movie->name,
                'date' => $movieDetails->date,
                'week' => $movieDetails->week,
                'startTime' => $movieDetails->start_time,
                'finishTime' => $movieDetails->finish_time,
                'seatColumn' => $reservationDetails[0]['column_number'],
                'seatRecord' => $reservationDetails[0]['record_number'],
                'fee_id' => $reservationDetails[0]['fee_id'],
                'discount_id' => $reservationDetails[0]['discount_id'],
            ];
            $_SESSION['seat'] = [
                'member_id' => $memberId,
                'schedule_id' => $reservationDetails[0]['schedule_id'],
                'column_number' => $reservationDetails[0]['column_number'],
                'record_number' => $reservationDetails[0]['record_number'],
            ];
            $_SESSION['fee'] = $this->Fees->get($_SESSION['detail']['fee_id']);
        }
        //直接画面遷移の対応(途中でページを遷移したことによりセッションは残っていた場合も直接遷移させない)
        $isIllegalReferences = $this->referer(null, true) !== '/reserves/discount' && $this->referer(null, true) !== '/reserves/checkdetail' && $this->referer(null, true) !== '/reserves/payment';
        if (!(isset($_SESSION['detail']['discount_id'])) || $isIllegalReferences) {
            $this->request->session()->delete('seat');
            $this->request->session()->delete('detail');
            $this->request->session()->delete('schedule');
            $this->request->session()->delete('fee');
            return $this->redirect(['controller' => 'error']);
        }
        $this->viewBuilder()->setLayout('frame-title');
        $detail = $_SESSION['detail'];
        $feeTicket = $_SESSION['fee'];
        $title = '予約確認';
        if ((string)$_SESSION['detail']['discount_id'] !== '0') { //該当なしを選択していない場合
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
                $_SESSION['payment'] = [
                    'schedule_id' => $_SESSION['seat']['schedule_id'],
                    'column_number' => $_SESSION['seat']['column_number'],
                    'record_number' => $_SESSION['seat']['record_number'],
                    'fee' => $feeTicket->fee,
                    'discount_id' => $_SESSION['detail']['discount_id'],
                ];
                $this->request->session()->delete('seat');
                $this->request->session()->delete('schedule');
                $this->request->session()->delete('detail');
                $this->request->session()->delete('fee');
                return $this->redirect(['action' => 'payment']);
            } else {
                $this->request->session()->delete('seat');
                $this->request->session()->delete('schedule');
                $this->request->session()->delete('detail');
                $this->request->session()->delete('fee');
                return $this->redirect(['controller' => 'error']);
            }
        }
        $this->set(compact('title', 'detail', 'feeTicket'));
    }
    public function payment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $title = '決済方法';
        $memberId = $this->Auth->user('id');
        $reserve = new ReserveForm(); //validation

        if (empty($_SESSION['payment'])) {
            return $this->redirect(['controller' => 'error']);
        } else {
            $_SESSION['checkdetail'] = 1;
        }

        $cardsInfoOwn = $this->Creditcards->find('CardsInfoOwn', ['memberId' => $memberId]);
        if (!($cardsInfoOwn)) {
            //決済新規登録ページへ
            return $this->redirect(['controller' => 'mypage', 'action' => 'addpayment']);
        }
        // カードIDの暗号化 カード下4桁抽出
        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        foreach ($cardsInfoOwn as $key => $value) {
            $lastFourDigits = substr($value['card_number'], -4, 4);
            $encryptedCardId = Security::encrypt($value['id'], $securityKey, $securitySalt);
            $cardsInfoOwn[$key]['card_number'] = $lastFourDigits;
            $cardsInfoOwn[$key]['id'] = $encryptedCardId;
        }

        $totalOfOwnPoints = $this->Members->find()
            ->select(['total_point'])->where(['id' => $memberId])->first()->total_point;
        $screeningStartDate = $this->Schedules->find()->select(['start_date'])->where(['id' => $_SESSION['payment']['schedule_id']])->first()->start_date;
        $useDiscountDetail = $this->Discounts->find('UseDiscountDetail', ['start_date' => $screeningStartDate]);
        if (!(isset($useDiscountDetail))) {
            $useDiscountDetail['displayed_amount'] = 0;
            $noUseDiscount = true;
        }
        if (!(isset($noUseDiscount)) && $useDiscountDetail['is_minus'] === false) {
            $amountOfPayment = $useDiscountDetail['displayed_amount'];
        } else {
            $amountOfPayment = $_SESSION['payment']['fee'] - $useDiscountDetail['displayed_amount'];
        }
        if ($totalOfOwnPoints > $amountOfPayment) { //所持ポイント>支払額
            $totalOfOwnPoints = $amountOfPayment;
        }

        if ($this->request->is('post') && $reserve->execute($this->request->data)) {
            // カード
            $registeredOrder = (int)$this->request->data['registered_order']; //カードを登録した順番(1番目、2番目)
            if ($registeredOrder >= count($cardsInfoOwn)) { //不正なカードの時
                $this->request->session()->delete('checkdetail');
                $this->request->session()->delete('payment');
                return $this->redirect(['controller' => 'error']);
            }
            $useCreditcard = $cardsInfoOwn[$registeredOrder]['id'];
            // ポイント
            $usageOfPoints = $this->request->data['usage_of_points'];
            if ($usageOfPoints === 'no_use_point') {
                $_SESSION['payment']['creditcard_id'] = $useCreditcard;
                $_SESSION['payment']['use_point'] = 0;
                return $this->redirect(['action' => 'checkpayment']);
            }
            $usePoint = $this->request->data['use_point'];
            if ($usePoint > $totalOfOwnPoints) {
                $TooManyPointsError = '利用できるポイント以下の数字を入力してください';
                $this->set(compact('TooManyPointsError'));
            }
            if (empty($TooManyPointsError)) {
                $_SESSION['payment']['creditcard_id'] = $useCreditcard;
                $_SESSION['payment']['use_point'] = $usePoint;
                return $this->redirect(['action' => 'checkpayment']);
            }
        }
        $this->set(compact('title', 'reserve', 'cardsInfoOwn', 'totalOfOwnPoints'));
    }
    public function checkpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $title = '決済概要';
        if (empty($_SESSION['payment'])) {
            $this->request->session()->delete('checkdetail');
            $this->request->session()->delete('payment');
            return $this->redirect(['controller' => 'error']);
        }
        $fee = $_SESSION['payment']['fee'];
        $screeningStartDate = $this->Schedules->find()->select(['start_date'])->where(['id' => $_SESSION['payment']['schedule_id']])->first()->start_date;
        $useDiscountDetail = $this->Discounts->find('UseDiscountDetail', ['start_date' => $screeningStartDate]);
        if (isset($useDiscountDetail)) {
            $discountName = $useDiscountDetail['name'];
        } else {
            $discountName = null;
            $useDiscountDetail['displayed_amount'] = 0;
            $noUseDiscount = true;
        }
        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        $useCreditcard = Security::decrypt($_SESSION['payment']['creditcard_id'], $securityKey, $securitySalt);

        $displayedAmount = $useDiscountDetail['displayed_amount'];

        $usePoint = $_SESSION['payment']['use_point'];
        // is_minusが立ってるかで処理を変える
        if (!(isset($noUseDiscount)) && $useDiscountDetail['is_minus'] === false) {
            $subTotal = $useDiscountDetail['displayed_amount'] - $usePoint;
        } else {
            $subTotal = $fee - $useDiscountDetail['displayed_amount'] - $usePoint;
        }
        $taxRate = $this->Taxes->find()->select(['tax_rate'])->where([
            'started_at <=' => $screeningStartDate, 'OR' => [['finished_at >=' => $screeningStartDate], ['finished_at IS NULL']],
        ])->first()->tax_rate;
        $tax = floor($subTotal * ($taxRate / 100));
        $purchasePrice = $subTotal + $tax;

        $this->set(compact('fee', 'discountName', 'displayedAmount', 'subTotal', 'tax', 'purchasePrice'));

        $paymentsEntity = $this->Payments->newEntity();
        if ($this->request->is('post')) {
            $today = Time::now();
            $memberId = $this->Auth->user('id');

            $payments = [
                'member_id' => (int)$memberId,
                'schedule_id' => (int)$_SESSION['schedule_id'],
                'column_number' => $_SESSION['payment']['column_number'],
                'record_number' => $_SESSION['payment']['record_number'],
                'creditcard_id' => $useCreditcard,
                'purchase_price' => (int)$purchasePrice,
                'is_cancelled' => 0,
                'created_at' => $today,
                'updated_at' => $today
            ];
            $pointRate = $this->PointRates->find()->select(['point_rate'])->where([
                'started_at <=' => $screeningStartDate, 'OR' => [['finished_at >=' => $screeningStartDate], ['finished_at IS NULL']],
            ])->first()->point_rate;
            $givePoint = floor($purchasePrice * ($pointRate / 100));
            $points = [
                [ //usePoints
                    'member_id' => (int)$memberId,
                    'schedule_id' => (int)$_SESSION['payment']['schedule_id'],
                    'column_number' => $_SESSION['payment']['column_number'],
                    'record_number' => $_SESSION['payment']['record_number'],
                    'point' => (int)$_SESSION['payment']['use_point'],
                    'is_minus' => 1,
                    'is_cancelled' => 0,
                    'created_at' => $today,
                    'updated_at' => $today,
                ],
                [ //givePoints
                    'member_id' => (int)$memberId,
                    'schedule_id' => (int)$_SESSION['schedule_id'],
                    'column_number' => $_SESSION['payment']['column_number'],
                    'record_number' => $_SESSION['payment']['record_number'],
                    'point' => (int)$givePoint,
                    'is_minus' => (int)0,
                    'is_cancelled' => 0,
                    'created_at' => $today,
                    'updated_at' => $today,
                ],
            ];
            $PointsEntity = $this->Points->newEntities($points);
            $payments = $this->Payments->patchEntity($paymentsEntity, $payments);
            $membersEntity = $this->Members->get($memberId);
            $totalOfOwnPoints = $this->Members->find()
                ->select(['total_point'])->where(['id' => $memberId])->first()->total_point;
            $membersEntity['total_point'] = $totalOfOwnPoints - $_SESSION['payment']['use_point'] + $givePoint;
            if ($this->Payments->insert($payments) && $this->Points->saveMany($PointsEntity, [['checkExisting' => false]]) && $this->Members->save($membersEntity)) {
                return $this->redirect(['action' => 'finished']);
            } else {
                return $this->redirect(['controller' => 'error']);
            }
        }
        $usePoint = $_SESSION['payment']['use_point'];
        $this->set(compact('title', 'usePoint'));
    }
    public function finished()
    {
        $this->viewBuilder()->setLayout('frame-no-title');
        if (empty($_SESSION['payment'])) {
            $this->request->session()->delete('checkdetail');
            $this->request->session()->delete('payment');
            return $this->redirect(['controller' => 'error']);
        }
        $this->request->session()->delete('checkdetail');
        $this->request->session()->delete('payment');
    }
}
