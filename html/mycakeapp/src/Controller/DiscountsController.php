<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Discounts Controller
 *
 * @property \App\Model\Table\DiscountsTable $Discounts
 *
 * @method \App\Model\Entity\Discount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DiscountsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $discounts = $this->paginate($this->Discounts);

        $this->set(compact('discounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $discount = $this->Discounts->get($id, [
            'contain' => ['ReservationDetails'],
        ]);

        $this->set('discount', $discount);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $discount = $this->Discounts->newEntity();
        if ($this->request->is('post')) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->getData());
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount could not be saved. Please, try again.'));
        }
        $this->set(compact('discount'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $discount = $this->Discounts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $discount = $this->Discounts->patchEntity($discount, $this->request->getData());
            if ($this->Discounts->save($discount)) {
                $this->Flash->success(__('The discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The discount could not be saved. Please, try again.'));
        }
        $this->set(compact('discount'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Discount id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $discount = $this->Discounts->get($id);
        if ($this->Discounts->delete($discount)) {
            $this->Flash->success(__('The discount has been deleted.'));
        } else {
            $this->Flash->error(__('The discount could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
