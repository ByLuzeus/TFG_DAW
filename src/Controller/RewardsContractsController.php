<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RewardsContracts Controller
 *
 * @property \App\Model\Table\RewardsContractsTable $RewardsContracts
 * @method \App\Model\Entity\RewardsContract[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RewardsContractsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rewards', 'Contracts'],
        ];
        $rewardsContracts = $this->paginate($this->RewardsContracts);

        $this->set(compact('rewardsContracts'));
    }

    /**
     * View method
     *
     * @param string|null $id Rewards Contract id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rewardsContract = $this->RewardsContracts->get($id, [
            'contain' => ['Rewards', 'Contracts'],
        ]);

        $this->set(compact('rewardsContract'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rewardsContract = $this->RewardsContracts->newEmptyEntity();
        if ($this->request->is('post')) {
            $rewardsContract = $this->RewardsContracts->patchEntity($rewardsContract, $this->request->getData());
            if ($this->RewardsContracts->save($rewardsContract)) {
                $this->Flash->success(__('The rewards contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rewards contract could not be saved. Please, try again.'));
        }
        $rewards = $this->RewardsContracts->Rewards->find('list', ['limit' => 200])->all();
        $contracts = $this->RewardsContracts->Contracts->find('list', ['limit' => 200])->all();
        $this->set(compact('rewardsContract', 'rewards', 'contracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rewards Contract id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rewardsContract = $this->RewardsContracts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rewardsContract = $this->RewardsContracts->patchEntity($rewardsContract, $this->request->getData());
            if ($this->RewardsContracts->save($rewardsContract)) {
                $this->Flash->success(__('The rewards contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rewards contract could not be saved. Please, try again.'));
        }
        $rewards = $this->RewardsContracts->Rewards->find('list', ['limit' => 200])->all();
        $contracts = $this->RewardsContracts->Contracts->find('list', ['limit' => 200])->all();
        $this->set(compact('rewardsContract', 'rewards', 'contracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rewards Contract id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rewardsContract = $this->RewardsContracts->get($id);
        if ($this->RewardsContracts->delete($rewardsContract)) {
            $this->Flash->success(__('The rewards contract has been deleted.'));
        } else {
            $this->Flash->error(__('The rewards contract could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
