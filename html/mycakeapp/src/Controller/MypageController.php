<?php

namespace App\Controller;

use App\Controller\AppController;

class MypageController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $member = $this->Auth->user();
        if (empty($member)) {
            return $this->redirect(['controller' => 'error']);
        }
        $this->loadModel('Members');
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
        if (empty($_SERVER['HTTP_REFERER'])) {
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
        $this->Auth->logout();
        return $this->redirect(['controller' => 'members', 'action' => 'deleted']);
    }
}
