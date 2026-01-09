<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;

/**
 * Commitmenttypes Controller
 *
 * @property \App\Model\Table\CommitmenttypesTable $Commitmenttypes
 * @method \App\Model\Entity\Commitmenttype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommitmenttypesController extends AppController
{

    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['def_commitmenttypes']);
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
        $commitmenttypes = $this->paginate($this->Commitmenttypes);

        $this->set(compact('commitmenttypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Commitmenttype id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $commitmenttype = $this->Commitmenttypes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('commitmenttype'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $commitmenttype = $this->Commitmenttypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $commitmenttype = $this->Commitmenttypes->patchEntity($commitmenttype, $this->request->getData());
            if ($this->Commitmenttypes->save($commitmenttype)) {
                $this->Flash->success(__('The commitmenttype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commitmenttype could not be saved. Please, try again.'));
        }
        $this->set(compact('commitmenttype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Commitmenttype id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $commitmentType = $this->Commitmenttypes->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $commitmentType = $this->Commitmenttypes->patchEntity(
                $commitmentType,
                $this->request->getData()
            );
            if ($this->Commitmenttypes->save($commitmentType)) {
                $this->Flash->success(__('El tipo de compromiso se ha actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el tipo de compromiso. Revisa los campos obligatorios.'));
        }
        $this->set(compact('commitmentType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Commitmenttype id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $commitmenttype = $this->Commitmenttypes->get($id);
        if ($this->Commitmenttypes->delete($commitmenttype)) {
            $this->Flash->success(__('The commitmenttype has been deleted.'));
        } else {
            $this->Flash->error(__('The commitmenttype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
