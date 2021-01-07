<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SlideshowPictures Controller
 *
 * @property \App\Model\Table\SlideshowPicturesTable $SlideshowPictures
 *
 * @method \App\Model\Entity\SlideshowPicture[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SlideshowPicturesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Movies'],
        ];
        $slideshowPictures = $this->paginate($this->SlideshowPictures);

        $this->set(compact('slideshowPictures'));
    }

    /**
     * View method
     *
     * @param string|null $id Slideshow Picture id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $slideshowPicture = $this->SlideshowPictures->get($id, [
            'contain' => ['Movies'],
        ]);

        $this->set('slideshowPicture', $slideshowPicture);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $slideshowPicture = $this->SlideshowPictures->newEntity();
        if ($this->request->is('post')) {
            $slideshowPicture = $this->SlideshowPictures->patchEntity($slideshowPicture, $this->request->getData());
            if ($this->SlideshowPictures->save($slideshowPicture)) {
                $this->Flash->success(__('The slideshow picture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The slideshow picture could not be saved. Please, try again.'));
        }
        $movies = $this->SlideshowPictures->Movies->find('list', ['limit' => 200]);
        $this->set(compact('slideshowPicture', 'movies'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Slideshow Picture id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $slideshowPicture = $this->SlideshowPictures->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $slideshowPicture = $this->SlideshowPictures->patchEntity($slideshowPicture, $this->request->getData());
            if ($this->SlideshowPictures->save($slideshowPicture)) {
                $this->Flash->success(__('The slideshow picture has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The slideshow picture could not be saved. Please, try again.'));
        }
        $movies = $this->SlideshowPictures->Movies->find('list', ['limit' => 200]);
        $this->set(compact('slideshowPicture', 'movies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Slideshow Picture id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $slideshowPicture = $this->SlideshowPictures->get($id);
        if ($this->SlideshowPictures->delete($slideshowPicture)) {
            $this->Flash->success(__('The slideshow picture has been deleted.'));
        } else {
            $this->Flash->error(__('The slideshow picture could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
