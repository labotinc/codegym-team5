<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Theaters Controller
 *
 * @property \App\Model\Table\TheatersTable $Theaters
 *
 * @method \App\Model\Entity\Theater[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TheatersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $theaters = $this->paginate($this->Theaters);

        $this->set(compact('theaters'));
    }

    /**
     * View method
     *
     * @param string|null $id Theater id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $theater = $this->Theaters->get($id, [
            'contain' => ['Schedules'],
        ]);

        $this->set('theater', $theater);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $theater = $this->Theaters->newEntity();
        if ($this->request->is('post')) {
            $theater = $this->Theaters->patchEntity($theater, $this->request->getData());
            if ($this->Theaters->save($theater)) {
                $this->Flash->success(__('The theater has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The theater could not be saved. Please, try again.'));
        }
        $this->set(compact('theater'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Theater id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $theater = $this->Theaters->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $theater = $this->Theaters->patchEntity($theater, $this->request->getData());
            if ($this->Theaters->save($theater)) {
                $this->Flash->success(__('The theater has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The theater could not be saved. Please, try again.'));
        }
        $this->set(compact('theater'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Theater id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $theater = $this->Theaters->get($id);
        if ($this->Theaters->delete($theater)) {
            $this->Flash->success(__('The theater has been deleted.'));
        } else {
            $this->Flash->error(__('The theater could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
