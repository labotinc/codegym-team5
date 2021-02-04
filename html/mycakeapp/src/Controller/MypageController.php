<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Security;
use Cake\Core\Configure;

class MypageController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Members');
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
    public function checkpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $memberId = $this->Auth->user('id');
        $today = date('Ymd');
        $cardsInfoOwn = $this->Creditcards->find()
            ->select(['id', 'name', 'card_number', 'deadline'])
            ->where([
                'member_id' => $memberId,
                'is_deleted' => 0,
                'deadline >=' => $today
            ])
            ->order(['created_at' => 'asc'])
            ->hydrate(false)->toArray();
        $securityKey = Configure::read('key');
        $securitySalt = Configure::read('salt');
        foreach ($cardsInfoOwn as $key => $value) {
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
        $today = date('Ymd');
        if (!empty($this->request->query['id'])) { //update
            // 暗号化したクレジットカードIDを戻す
            $securityKey = Configure::read('key');
            $securitySalt = Configure::read('salt');
            $encryptedCardId = $this->request->query['id'];
            $cardId = Security::decrypt($encryptedCardId, $securityKey, $securitySalt);
            if ($cardId === false) { //不正なIDの時
                return $this->redirect(['controller' => 'error']);
            }
            $cardHolderIsMember = $this->Creditcards->find()
                ->where([
                    'id' => $cardId,
                    'member_id' => $memberId,
                    'is_deleted' => 0,
                    'deadline >=' => $today
                ])->count();
            if (!($cardHolderIsMember)) { //カードがユーザーのものじゃない時
                return $this->redirect(['controller' => 'error']);
            }

            $entity = $this->Creditcards->get($cardId);
            $entity = $this->Creditcards->patchEntity($entity, $this->request->getData());
            //updateの日付のみ更新
            if ($this->Creditcards->save($entity)) {
                $_SESSION['addedpayment'] = 1;
                return $this->redirect(['action' => 'addedpayment']);
            }
        } else { //insertのカード数判定
            $numbeOfCardsOwned = $this->Creditcards->find()->where([
                'member_id' => $this->Auth->user('id'),
                'is_deleted' => 0,
                'deadline >=' => $today
            ])->count();
            if ($numbeOfCardsOwned === 2) {
                return $this->redirect(['controller' => 'error']);
            }
        }
        if (!empty($this->request->is('post'))) { //insert
            $entity = $this->Creditcards->patchEntity($entity, $this->request->getData());
            $entity["member_id"] = $this->Auth->user('id');
            $entity["is_deleted"] = 0;
            $entity["created_at"] = date("Y/m/d H:i:s");
            $entity["updated_at"] = date("Y/m/d H:i:s");
            if ($this->Creditcards->save($entity)) {
                $_SESSION['addedpayment'] = 1;
                return $this->redirect(['action' => 'addedpayment']);
            }
        }
        $title = "会員登録";
        $this->set(compact('entity', 'title'));
    }
    public function addedpayment()
    {
        $this->viewBuilder()->setLayout('frame-title');
        if (empty($_SESSION['addedpayment'])) {
            return $this->redirect(['controller' => 'error']);
        }
        $_SESSION['addedpayment'] = null;
        $title = "会員登録";
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
        $today = date('Ymd');
        $cardHolderIsMember = $this->Creditcards->find()
            ->where([
                'id' => $cardId,
                'member_id' => $this->Auth->user('id'),
                'is_deleted' => 0,
                'deadline >=' => $today
            ])->count();
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
        $_SESSION['deletedpayment'] = null;
        $title = "会員登録";
        $this->set(compact('title'));
    }
}
