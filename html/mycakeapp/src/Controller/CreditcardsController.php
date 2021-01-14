<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Creditcards Controller
 *
 * @property \App\Model\Table\CreditcardsTable $Creditcards
 *
 * @method \App\Model\Entity\Creditcard[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CreditcardsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Members'],
        ];
        $creditcards = $this->paginate($this->Creditcards);

        $this->set(compact('creditcards'));
    }

    /**
     * View method
     *
     * @param string|null $id Creditcard id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $creditcard = $this->Creditcards->get($id, [
            'contain' => ['Members', 'Payments'],
        ]);

        $this->set('creditcard', $creditcard);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $creditcard = $this->Creditcards->newEntity();
        if ($this->request->is('post')) {
            $creditcard = $this->Creditcards->patchEntity($creditcard, $this->request->getData());
            if ($this->Creditcards->save($creditcard)) {
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
        }
        $members = $this->Creditcards->Members->find('list', ['limit' => 200]);
        $this->set(compact('creditcard', 'members'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Creditcard id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $creditcard = $this->Creditcards->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $creditcard = $this->Creditcards->patchEntity($creditcard, $this->request->getData());
            if ($this->Creditcards->save($creditcard)) {
                $this->Flash->success(__('The creditcard has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The creditcard could not be saved. Please, try again.'));
        }
        $members = $this->Creditcards->Members->find('list', ['limit' => 200]);
        $this->set(compact('creditcard', 'members'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Creditcard id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $creditcard = $this->Creditcards->get($id);
        if ($this->Creditcards->delete($creditcard)) {
            $this->Flash->success(__('The creditcard has been deleted.'));
        } else {
            $this->Flash->error(__('The creditcard could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
