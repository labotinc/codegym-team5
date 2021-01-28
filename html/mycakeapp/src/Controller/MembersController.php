<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Controller\Component\AuthComponent;
use Cake\Event\Event;
use Cake\Routing\Router;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 *
 * @method \App\Model\Entity\Member[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MembersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $member = $this->Auth->user();
        if (!empty($member) && $this->request->action !== 'logout') {
            // コードレビュー時はコメント化してください
            return $this->redirect(['controller' => 'error']);
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $members = $this->paginate($this->Members);

        $this->set(compact('members'));
    }

    /**
     * View method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => ['Creditcards', 'Payments', 'Points', 'ReservationDetails', 'SeatReservations'],
        ]);

        $this->set('member', $member);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $member = $this->Members->newEntity();
        if ($this->request->is('post')) {
            $member = $this->Members->patchEntity($member, $this->request->getData());
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The member could not be saved. Please, try again.'));
        }
        $this->set(compact('member'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $member = $this->Members->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $member = $this->Members->patchEntity($member, $this->request->getData());
            if ($this->Members->save($member)) {
                $this->Flash->success(__('The member has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The member could not be saved. Please, try again.'));
        }
        $this->set(compact('member'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Member id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $member = $this->Members->get($id);
        if ($this->Members->delete($member)) {
            $this->Flash->success(__('The member has been deleted.'));
        } else {
            $this->Flash->error(__('The member could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function create()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $entity = $this->Members->newEntity();
        if ($this->request->is('post')) {
            $entity = $this->Members->patchEntity($entity, $this->request->getData());
            $entity["total_point"] = 0;
            $entity["is_deleted"] = 0;
            $entity["is_provisional"] = 0;
            $entity["created_at"] = date("Y/m/d H:i:s");
            $entity["updated_at"] = date("Y/m/d H:i:s");
            if ($this->Members->save($entity)) {
                return $this->redirect(['action' => 'saved'], 308);
            }
        }
        $title = "会員登録";
        $this->set(compact('entity', 'title'));
    }
    public function saved()
    {
        $this->viewBuilder()->setLayout('frame-no-title');
        if (!($this->request->is('post'))) {
            return $this->redirect(['controller' => 'error']);
        }
    }

    public function password()
    {
        $this->viewBuilder()->setLayout('frame-title');
        if ($this->request->is('post')) {
            $entity = $this->Members->newEntity($this->request->getData());
            //↓バリデーションエラーが発生しない場合
            if (empty($entity->errors('password')) && empty($entity->errors('rePassword')) && empty($entity->errors('email'))) {
                //↓入力したemailがMembersテーブルに存在する場合。ただし、存在しない場合もメールは送らないが登録完了ページへ遷移させる(基本設計書参照)。
                if (!empty($this->Members->findByEmail($this->request->data['email'])->toArray())) {
                    $entity = $this->Members->findByEmail($this->request->data['email'])->toArray();
                    $entity[0]['password'] = $this->request->data['password'];
                    if ($this->Members->save($entity[0])) {
                        return $this->redirect(['action' => 'changed'],308);
                    }
                }
                return $this->redirect(['action' => 'changed'],308);
            }
        } else {
            $entity = $this->Members->newEntity();
        }
        $title = 'パスワード再登録';
        $this->set(compact('entity', 'title'));
    }

    public function changed()
    {
        $this->viewBuilder()->setLayout('frame-no-title');
        if (!($this->request->is('post'))) {
            return $this->redirect(['controller' => 'error']);
        }
    }
    public function login()
    {
        $this->viewBuilder()->setLayout('frame-title');
        $entity = $this->Members->newEntity();
        if ($this->request->is('post')) {
            // ログイン用のvalidationを適応
            $entity = $this->Members->patchEntity($entity, $this->request->getData(), ['validate' => 'login']);
            $member = $this->Auth->identify();
            if (!empty($member)) { //認証成功
                $this->Auth->setUser($member);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $AuthCError = 'メールアドレスかパスワードまたはその両方が間違っているようです';
            $this->set(compact('AuthCError'));
        }
        $title = 'ログイン';
        $this->set(compact('entity', 'title'));
    }
    public function logout()
    {
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }
}
