<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\View\CellTrait;

/**
 * Removes Controller
 *
 * @property \App\Model\Table\RemovesTable $Removes
 */
class RemovesController extends AppController
{

    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin',['removes']);
        $this->set(['menuadmin' => $menuadmin]);
        $headeradmin = $this->cell('Headeradmin',[$this->Auth->user()]);
        $this->set(['headeradmin' => $headeradmin]);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $removes = $this->Removes->find()->contain(['Users'])->all();

        $this->set(compact('removes'));
    }
}