<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;

/**
 * Commitments Controller
 *
 * @property \App\Model\Table\CommitmentsTable $Commitments
 * @method \App\Model\Entity\Commitment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommitmentsController extends AppController
{

    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['def_commitments']);
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
        $this->paginate = [
            'contain' => ['Commitmenttypes'],
        ];
        $commitments = $this->paginate($this->Commitments);

        $this->set(compact('commitments'));
    }

    /**
     * View method
     *
     * @param string|null $id Commitment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $commitment = $this->Commitments->get($id, [
            'contain' => ['Commitmenttypes', 'Contracts', 'Consequences', 'Rewards'],
        ]);

        $this->set(compact('commitment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $commitment = $this->Commitments->newEmptyEntity();
        if ($this->request->is('post')) {
            $commitment = $this->Commitments->patchEntity($commitment, $this->request->getData());
            if ($this->Commitments->save($commitment)) {
                $this->Flash->success(__('The commitment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commitment could not be saved. Please, try again.'));
        }
        $commitmenttypes = $this->Commitments->Commitmenttypes->find('list', ['limit' => 200])->all();
        $contracts = $this->Commitments->Contracts->find('list', ['limit' => 200])->all();
        $consequences = $this->Commitments->Consequences->find('list', ['limit' => 200])->all();
        $rewards = $this->Commitments->Rewards->find('list', ['limit' => 200])->all();
        $this->set(compact('commitment', 'commitmenttypes', 'contracts', 'consequences', 'rewards'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Commitment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $commitment = $this->Commitments->get($id, [
            'contain' => ['Commitmenttypes']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['type_id'] = $commitment->type_id;
            $commitment = $this->Commitments->patchEntity($commitment, $data);

            if ($this->Commitments->save($commitment)) {
                $this->Flash->success(__('El compromiso se ha actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar el compromiso. Revisa los campos obligatorios.'));
        }
        $this->set(compact('commitment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Commitment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $commitment = $this->Commitments->get($id);
        if ($this->Commitments->delete($commitment)) {
            $this->Flash->success(__('The commitment has been deleted.'));
        } else {
            $this->Flash->error(__('The commitment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
