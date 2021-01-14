<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ReservationDetails Controller
 *
 * @property \App\Model\Table\ReservationDetailsTable $ReservationDetails
 *
 * @method \App\Model\Entity\ReservationDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReservationDetailsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Members', 'Schedules', 'Fees', 'Discounts'],
        ];
        $reservationDetails = $this->paginate($this->ReservationDetails);

        $this->set(compact('reservationDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Reservation Detail id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reservationDetail = $this->ReservationDetails->get($id, [
            'contain' => ['Members', 'Schedules', 'Fees', 'Discounts'],
        ]);

        $this->set('reservationDetail', $reservationDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reservationDetail = $this->ReservationDetails->newEntity();
        if ($this->request->is('post')) {
            $reservationDetail = $this->ReservationDetails->patchEntity($reservationDetail, $this->request->getData());
            if ($this->ReservationDetails->save($reservationDetail)) {
                $this->Flash->success(__('The reservation detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reservation detail could not be saved. Please, try again.'));
        }
        $members = $this->ReservationDetails->Members->find('list', ['limit' => 200]);
        $schedules = $this->ReservationDetails->Schedules->find('list', ['limit' => 200]);
        $fees = $this->ReservationDetails->Fees->find('list', ['limit' => 200]);
        $discounts = $this->ReservationDetails->Discounts->find('list', ['limit' => 200]);
        $this->set(compact('reservationDetail', 'members', 'schedules', 'fees', 'discounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reservation Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reservationDetail = $this->ReservationDetails->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reservationDetail = $this->ReservationDetails->patchEntity($reservationDetail, $this->request->getData());
            if ($this->ReservationDetails->save($reservationDetail)) {
                $this->Flash->success(__('The reservation detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reservation detail could not be saved. Please, try again.'));
        }
        $members = $this->ReservationDetails->Members->find('list', ['limit' => 200]);
        $schedules = $this->ReservationDetails->Schedules->find('list', ['limit' => 200]);
        $fees = $this->ReservationDetails->Fees->find('list', ['limit' => 200]);
        $discounts = $this->ReservationDetails->Discounts->find('list', ['limit' => 200]);
        $this->set(compact('reservationDetail', 'members', 'schedules', 'fees', 'discounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reservation Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reservationDetail = $this->ReservationDetails->get($id);
        if ($this->ReservationDetails->delete($reservationDetail)) {
            $this->Flash->success(__('The reservation detail has been deleted.'));
        } else {
            $this->Flash->error(__('The reservation detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
