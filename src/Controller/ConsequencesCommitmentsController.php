<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ConsequencesCommitments Controller
 *
 * @property \App\Model\Table\ConsequencesCommitmentsTable $ConsequencesCommitments
 * @method \App\Model\Entity\ConsequencesCommitment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsequencesCommitmentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ConsequencesContacts', 'Commitmentscontracts'],
        ];
        $consequencesCommitments = $this->paginate($this->ConsequencesCommitments);

        $this->set(compact('consequencesCommitments'));
    }

    /**
     * View method
     *
     * @param string|null $id Consequences Commitment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consequencesCommitment = $this->ConsequencesCommitments->get($id, [
            'contain' => ['ConsequencesContacts', 'Commitmentscontracts'],
        ]);

        $this->set(compact('consequencesCommitment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consequencesCommitment = $this->ConsequencesCommitments->newEmptyEntity();
        if ($this->request->is('post')) {
            $consequencesCommitment = $this->ConsequencesCommitments->patchEntity($consequencesCommitment, $this->request->getData());
            if ($this->ConsequencesCommitments->save($consequencesCommitment)) {
                $this->Flash->success(__('The consequences commitment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consequences commitment could not be saved. Please, try again.'));
        }
        $consequencesContacts = $this->ConsequencesCommitments->ConsequencesContacts->find('list', ['limit' => 200])->all();
        $commitmentscontracts = $this->ConsequencesCommitments->Commitmentscontracts->find('list', ['limit' => 200])->all();
        $this->set(compact('consequencesCommitment', 'consequencesContacts', 'commitmentscontracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consequences Commitment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consequencesCommitment = $this->ConsequencesCommitments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consequencesCommitment = $this->ConsequencesCommitments->patchEntity($consequencesCommitment, $this->request->getData());
            if ($this->ConsequencesCommitments->save($consequencesCommitment)) {
                $this->Flash->success(__('The consequences commitment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consequences commitment could not be saved. Please, try again.'));
        }
        $consequencesContacts = $this->ConsequencesCommitments->ConsequencesContacts->find('list', ['limit' => 200])->all();
        $commitmentscontracts = $this->ConsequencesCommitments->Commitmentscontracts->find('list', ['limit' => 200])->all();
        $this->set(compact('consequencesCommitment', 'consequencesContacts', 'commitmentscontracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consequences Commitment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consequencesCommitment = $this->ConsequencesCommitments->get($id);
        if ($this->ConsequencesCommitments->delete($consequencesCommitment)) {
            $this->Flash->success(__('The consequences commitment has been deleted.'));
        } else {
            $this->Flash->error(__('The consequences commitment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
