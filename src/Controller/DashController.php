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
class DashController extends AppController
{

    use CellTrait;


    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
      parent::beforeFilter($event);
      $menuadmin = $this->cell('Menuadmin',['dashboard']);
      $headeradmin = $this->cell('Headeradmin',[$this->Auth->user()]);
      $this->set(['menuadmin' => $menuadmin]);
      $this->set(['headeradmin' => $headeradmin]);
    }


    public function index()
    {

      $logstable = TableRegistry::get('Logs');
      $logs = $logstable->find()->order(['created'=>'DESC'])->limit(5)->all();
      $this->set('logs', $logs);


    }
}
