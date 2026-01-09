<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Consequences Controller
 *
 * @property \App\Model\Table\ConsequencesTable $Consequences
 * @method \App\Model\Entity\Consequence[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsequencesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Rewardsconsequencestypes'],
        ];
        $consequences = $this->paginate($this->Consequences);

        $this->set(compact('consequences'));
    }

    /**
     * View method
     *
     * @param string|null $id Consequence id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consequence = $this->Consequences->get($id, [
            'contain' => ['Rewardsconsequencestypes', 'Commitments', 'ConsequencesContacts'],
        ]);

        $this->set(compact('consequence'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consequence = $this->Consequences->newEmptyEntity();
        if ($this->request->is('post')) {
            $consequence = $this->Consequences->patchEntity($consequence, $this->request->getData());
            if ($this->Consequences->save($consequence)) {
                $this->Flash->success(__('The consequence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consequence could not be saved. Please, try again.'));
        }
        $rewardsconsequencestypes = $this->Consequences->Rewardsconsequencestypes->find('list', ['limit' => 200])->all();
        $commitments = $this->Consequences->Commitments->find('list', ['limit' => 200])->all();
        $this->set(compact('consequence', 'rewardsconsequencestypes', 'commitments'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consequence id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consequence = $this->Consequences->get($id, [
            'contain' => ['Commitments'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consequence = $this->Consequences->patchEntity($consequence, $this->request->getData());
            if ($this->Consequences->save($consequence)) {
                $this->Flash->success(__('The consequence has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consequence could not be saved. Please, try again.'));
        }
        $rewardsconsequencestypes = $this->Consequences->Rewardsconsequencestypes->find('list', ['limit' => 200])->all();
        $commitments = $this->Consequences->Commitments->find('list', ['limit' => 200])->all();
        $this->set(compact('consequence', 'rewardsconsequencestypes', 'commitments'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consequence id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consequence = $this->Consequences->get($id);
        if ($this->Consequences->delete($consequence)) {
            $this->Flash->success(__('The consequence has been deleted.'));
        } else {
            $this->Flash->error(__('The consequence could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
