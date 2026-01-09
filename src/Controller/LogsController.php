<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\View\CellTrait;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class LogsController extends AppController
{


    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['logs']);
        $this->set(['menuadmin' => $menuadmin]);
        $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
        $this->set(['headeradmin' => $headeradmin]);
    }

    public function index()
    {
        $logs = $this->Logs->find()->all();
        $this->set(compact('logs'));
    }


}
