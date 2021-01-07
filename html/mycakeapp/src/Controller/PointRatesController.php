<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PointRates Controller
 *
 * @property \App\Model\Table\PointRatesTable $PointRates
 *
 * @method \App\Model\Entity\PointRate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PointRatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $pointRates = $this->paginate($this->PointRates);

        $this->set(compact('pointRates'));
    }

    /**
     * View method
     *
     * @param string|null $id Point Rate id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pointRate = $this->PointRates->get($id, [
            'contain' => [],
        ]);

        $this->set('pointRate', $pointRate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pointRate = $this->PointRates->newEntity();
        if ($this->request->is('post')) {
            $pointRate = $this->PointRates->patchEntity($pointRate, $this->request->getData());
            if ($this->PointRates->save($pointRate)) {
                $this->Flash->success(__('The point rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The point rate could not be saved. Please, try again.'));
        }
        $this->set(compact('pointRate'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Point Rate id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pointRate = $this->PointRates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pointRate = $this->PointRates->patchEntity($pointRate, $this->request->getData());
            if ($this->PointRates->save($pointRate)) {
                $this->Flash->success(__('The point rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The point rate could not be saved. Please, try again.'));
        }
        $this->set(compact('pointRate'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Point Rate id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pointRate = $this->PointRates->get($id);
        if ($this->PointRates->delete($pointRate)) {
            $this->Flash->success(__('The point rate has been deleted.'));
        } else {
            $this->Flash->error(__('The point rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
