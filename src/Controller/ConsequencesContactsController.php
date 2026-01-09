<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ConsequencesContacts Controller
 *
 * @property \App\Model\Table\ConsequencesContactsTable $ConsequencesContacts
 * @method \App\Model\Entity\ConsequencesContact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ConsequencesContactsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Consequences', 'Contracts'],
        ];
        $consequencesContacts = $this->paginate($this->ConsequencesContacts);

        $this->set(compact('consequencesContacts'));
    }

    /**
     * View method
     *
     * @param string|null $id Consequences Contact id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $consequencesContact = $this->ConsequencesContacts->get($id, [
            'contain' => ['Consequences', 'Contracts'],
        ]);

        $this->set(compact('consequencesContact'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $consequencesContact = $this->ConsequencesContacts->newEmptyEntity();
        if ($this->request->is('post')) {
            $consequencesContact = $this->ConsequencesContacts->patchEntity($consequencesContact, $this->request->getData());
            if ($this->ConsequencesContacts->save($consequencesContact)) {
                $this->Flash->success(__('The consequences contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consequences contact could not be saved. Please, try again.'));
        }
        $consequences = $this->ConsequencesContacts->Consequences->find('list', ['limit' => 200])->all();
        $contracts = $this->ConsequencesContacts->Contracts->find('list', ['limit' => 200])->all();
        $this->set(compact('consequencesContact', 'consequences', 'contracts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Consequences Contact id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $consequencesContact = $this->ConsequencesContacts->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $consequencesContact = $this->ConsequencesContacts->patchEntity($consequencesContact, $this->request->getData());
            if ($this->ConsequencesContacts->save($consequencesContact)) {
                $this->Flash->success(__('The consequences contact has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The consequences contact could not be saved. Please, try again.'));
        }
        $consequences = $this->ConsequencesContacts->Consequences->find('list', ['limit' => 200])->all();
        $contracts = $this->ConsequencesContacts->Contracts->find('list', ['limit' => 200])->all();
        $this->set(compact('consequencesContact', 'consequences', 'contracts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Consequences Contact id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $consequencesContact = $this->ConsequencesContacts->get($id);
        if ($this->ConsequencesContacts->delete($consequencesContact)) {
            $this->Flash->success(__('The consequences contact has been deleted.'));
        } else {
            $this->Flash->error(__('The consequences contact could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
