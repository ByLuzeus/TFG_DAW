<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * CommitmentsContracts Controller
 *
 * @property \App\Model\Table\CommitmentsContractsTable $CommitmentsContracts
 * @method \App\Model\Entity\CommitmentsContract[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommitmentsContractsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['States', 'Commitments', 'Contracts'],
        ];
        $commitmentsContracts = $this->paginate($this->CommitmentsContracts);

        $this->set(compact('commitmentsContracts'));
    }

    /**
     * View method
     *
     * @param string|null $id Commitments Contract id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $commitmentsContract = $this->CommitmentsContracts->get($id, [
            'contain' => ['States', 'Commitments', 'Contracts'],
        ]);

        $this->set(compact('commitmentsContract'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $commitmentsContract = $this->CommitmentsContracts->newEmptyEntity();
        if ($this->request->is('post')) {
            $commitmentsContract = $this->CommitmentsContracts->patchEntity($commitmentsContract, $this->request->getData());
            if ($this->CommitmentsContracts->save($commitmentsContract)) {
                $this->Flash->success(__('The commitments contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commitments contract could not be saved. Please, try again.'));
        }
        $states = $this->CommitmentsContracts->States->find('list', ['limit' => 200])->all();
        $commitments = $this->CommitmentsContracts->Commitments->find('list', ['limit' => 200])->all();
        $contracts = $this->CommitmentsContracts->Contracts->find('list', ['limit' => 200])->all();
        $this->set(compact('commitmentsContract', 'states', 'commitments', 'contracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Commitments Contract id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $commitmentsContract = $this->CommitmentsContracts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $commitmentsContract = $this->CommitmentsContracts->patchEntity($commitmentsContract, $this->request->getData());
            if ($this->CommitmentsContracts->save($commitmentsContract)) {
                $this->Flash->success(__('The commitments contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The commitments contract could not be saved. Please, try again.'));
        }
        $states = $this->CommitmentsContracts->States->find('list', ['limit' => 200])->all();
        $commitments = $this->CommitmentsContracts->Commitments->find('list', ['limit' => 200])->all();
        $contracts = $this->CommitmentsContracts->Contracts->find('list', ['limit' => 200])->all();
        $this->set(compact('commitmentsContract', 'states', 'commitments', 'contracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Commitments Contract id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $commitmentsContract = $this->CommitmentsContracts->get($id);
        if ($this->CommitmentsContracts->delete($commitmentsContract)) {
            $this->Flash->success(__('The commitments contract has been deleted.'));
        } else {
            $this->Flash->error(__('The commitments contract could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
