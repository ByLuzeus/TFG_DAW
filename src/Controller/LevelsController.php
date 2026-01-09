<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;

/**
 * Levels Controller
 *
 * @property \App\Model\Table\LevelsTable $Levels
 * @method \App\Model\Entity\Level[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LevelsController extends AppController
{

    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['def_levels']);
        $this->set(['menuadmin' => $menuadmin]);
        $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
        $this->set(['headeradmin' => $headeradmin]);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $levels = $this->paginate($this->Levels);

        $this->set(compact('levels'));
    }

    /**
     * View method
     *
     * @param string|null $id Level id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $level = $this->Levels->get($id, [
            'contain' => ['Users'],
        ]);

        $this->set(compact('level'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $level = $this->Levels->newEmptyEntity();
        if ($this->request->is('post')) {
            $level = $this->Levels->patchEntity($level, $this->request->getData());
            if ($this->Levels->save($level)) {
                $this->Flash->success(__('The level has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The level could not be saved. Please, try again.'));
        }
        $this->set(compact('level'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Level id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $level = $this->Levels->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $level = $this->Levels->patchEntity($level, $this->request->getData());
            if ($this->Levels->save($level)) {
                $this->Flash->success(__('El nivel se ha actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el nivel. Revisa los campos obligatorios.'));
        }
        $this->set(compact('level'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Level id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $level = $this->Levels->get($id);
        if ($this->Levels->delete($level)) {
            $this->Flash->success(__('The level has been deleted.'));
        } else {
            $this->Flash->error(__('The level could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
