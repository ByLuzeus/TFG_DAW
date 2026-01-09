<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;

/**
 * Rewardsconsequencestypes Controller
 *
 * @property \App\Model\Table\RewardsconsequencestypesTable $Rewardsconsequencestypes
 * @method \App\Model\Entity\Rewardsconsequencestype[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RewardsconsequencestypesController extends AppController
{
    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['def_rewardtypes']);
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
        $rewardsconsequencestypes = $this->paginate($this->Rewardsconsequencestypes);

        $this->set(compact('rewardsconsequencestypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Rewardsconsequencestype id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rewardsconsequencestype = $this->Rewardsconsequencestypes->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('rewardsconsequencestype'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rewardsconsequencestype = $this->Rewardsconsequencestypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $rewardsconsequencestype = $this->Rewardsconsequencestypes->patchEntity($rewardsconsequencestype, $this->request->getData());
            if ($this->Rewardsconsequencestypes->save($rewardsconsequencestype)) {
                $this->Flash->success(__('The rewardsconsequencestype has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rewardsconsequencestype could not be saved. Please, try again.'));
        }
        $this->set(compact('rewardsconsequencestype'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rewardsconsequencestype id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rewtype = $this->Rewardsconsequencestypes->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $rewtype = $this->Rewardsconsequencestypes->patchEntity($rewtype, $data);
            if ($this->Rewardsconsequencestypes->save($rewtype)) {
                $this->Flash->success(__('El tipo de recompensa se ha actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el tipo. Por favor, revisa los campos obligatorios.'));
        }
        // Pasamos la entidad a la vista
        $this->set(compact('rewtype'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rewardsconsequencestype id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rewardsconsequencestype = $this->Rewardsconsequencestypes->get($id);
        if ($this->Rewardsconsequencestypes->delete($rewardsconsequencestype)) {
            $this->Flash->success(__('The rewardsconsequencestype has been deleted.'));
        } else {
            $this->Flash->error(__('The rewardsconsequencestype could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
