<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SeatReservations Controller
 *
 * @property \App\Model\Table\SeatReservationsTable $SeatReservations
 *
 * @method \App\Model\Entity\SeatReservation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SeatReservationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Members', 'Schedules'],
        ];
        $seatReservations = $this->paginate($this->SeatReservations);

        $this->set(compact('seatReservations'));
    }

    /**
     * View method
     *
     * @param string|null $id Seat Reservation id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $seatReservation = $this->SeatReservations->get($id, [
            'contain' => ['Members', 'Schedules'],
        ]);

        $this->set('seatReservation', $seatReservation);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $seatReservation = $this->SeatReservations->newEntity();
        if ($this->request->is('post')) {
            $seatReservation = $this->SeatReservations->patchEntity($seatReservation, $this->request->getData());
            if ($this->SeatReservations->save($seatReservation)) {
                $this->Flash->success(__('The seat reservation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seat reservation could not be saved. Please, try again.'));
        }
        $members = $this->SeatReservations->Members->find('list', ['limit' => 200]);
        $schedules = $this->SeatReservations->Schedules->find('list', ['limit' => 200]);
        $this->set(compact('seatReservation', 'members', 'schedules'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Seat Reservation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $seatReservation = $this->SeatReservations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $seatReservation = $this->SeatReservations->patchEntity($seatReservation, $this->request->getData());
            if ($this->SeatReservations->save($seatReservation)) {
                $this->Flash->success(__('The seat reservation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The seat reservation could not be saved. Please, try again.'));
        }
        $members = $this->SeatReservations->Members->find('list', ['limit' => 200]);
        $schedules = $this->SeatReservations->Schedules->find('list', ['limit' => 200]);
        $this->set(compact('seatReservation', 'members', 'schedules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Seat Reservation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $seatReservation = $this->SeatReservations->get($id);
        if ($this->SeatReservations->delete($seatReservation)) {
            $this->Flash->success(__('The seat reservation has been deleted.'));
        } else {
            $this->Flash->error(__('The seat reservation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
