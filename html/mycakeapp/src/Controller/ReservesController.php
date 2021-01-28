<?php

namespace App\Controller;

use App\Controller\AppController;

class ReservesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $member = $this->Auth->user();
        if (empty($member) && $this->request->action !== 'seat') {
            return $this->redirect(['controller' => 'error']);
        }
    }
}
