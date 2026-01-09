<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * RewardsCommitments Controller
 *
 * @property \App\Model\Table\RewardsCommitmentsTable $RewardsCommitments
 * @method \App\Model\Entity\RewardsCommitment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RewardsCommitmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['RewardsContracts', 'Commitmentscontracts'],
        ];
        $rewardsCommitments = $this->paginate($this->RewardsCommitments);

        $this->set(compact('rewardsCommitments'));
    }

    /**
     * View method
     *
     * @param string|null $id Rewards Commitment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rewardsCommitment = $this->RewardsCommitments->get($id, [
            'contain' => ['RewardsContracts', 'Commitmentscontracts'],
        ]);

        $this->set(compact('rewardsCommitment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rewardsCommitment = $this->RewardsCommitments->newEmptyEntity();
        if ($this->request->is('post')) {
            $rewardsCommitment = $this->RewardsCommitments->patchEntity($rewardsCommitment, $this->request->getData());
            if ($this->RewardsCommitments->save($rewardsCommitment)) {
                $this->Flash->success(__('The rewards commitment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rewards commitment could not be saved. Please, try again.'));
        }
        $rewardsContracts = $this->RewardsCommitments->RewardsContracts->find('list', ['limit' => 200])->all();
        $commitmentscontracts = $this->RewardsCommitments->Commitmentscontracts->find('list', ['limit' => 200])->all();
        $this->set(compact('rewardsCommitment', 'rewardsContracts', 'commitmentscontracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rewards Commitment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rewardsCommitment = $this->RewardsCommitments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rewardsCommitment = $this->RewardsCommitments->patchEntity($rewardsCommitment, $this->request->getData());
            if ($this->RewardsCommitments->save($rewardsCommitment)) {
                $this->Flash->success(__('The rewards commitment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rewards commitment could not be saved. Please, try again.'));
        }
        $rewardsContracts = $this->RewardsCommitments->RewardsContracts->find('list', ['limit' => 200])->all();
        $commitmentscontracts = $this->RewardsCommitments->Commitmentscontracts->find('list', ['limit' => 200])->all();
        $this->set(compact('rewardsCommitment', 'rewardsContracts', 'commitmentscontracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rewards Commitment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rewardsCommitment = $this->RewardsCommitments->get($id);
        if ($this->RewardsCommitments->delete($rewardsCommitment)) {
            $this->Flash->success(__('The rewards commitment has been deleted.'));
        } else {
            $this->Flash->error(__('The rewards commitment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
