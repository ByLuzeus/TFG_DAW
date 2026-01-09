<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController as BaseAppController;

class AppController extends BaseAppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->RequestHandler->renderAs($this, 'json');
        $this->viewBuilder()->setClassName('Json');

        if ($this->components()->has('Auth')) {
            $this->Auth->allow();
        }
    }
}
