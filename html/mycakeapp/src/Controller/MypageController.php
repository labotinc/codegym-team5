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
    }
}
