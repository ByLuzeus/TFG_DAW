<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Welcomemessages Controller
 *
 * @property \App\Model\Table\WelcomemessagesTable $Welcomemessages
 * @method \App\Model\Entity\Welcomemessage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class WelcomemessagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $welcomemessages = $this->paginate($this->Welcomemessages);

        $this->set(compact('welcomemessages'));
    }

    /**
     * View method
     *
     * @param string|null $id Welcomemessage id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $welcomemessage = $this->Welcomemessages->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('welcomemessage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $welcomemessage = $this->Welcomemessages->newEmptyEntity();
        if ($this->request->is('post')) {
            $welcomemessage = $this->Welcomemessages->patchEntity($welcomemessage, $this->request->getData());
            if ($this->Welcomemessages->save($welcomemessage)) {
                $this->Flash->success(__('The welcomemessage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The welcomemessage could not be saved. Please, try again.'));
        }
        $this->set(compact('welcomemessage'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Welcomemessage id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $welcomemessage = $this->Welcomemessages->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $welcomemessage = $this->Welcomemessages->patchEntity($welcomemessage, $this->request->getData());
            if ($this->Welcomemessages->save($welcomemessage)) {
                $this->Flash->success(__('The welcomemessage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The welcomemessage could not be saved. Please, try again.'));
        }
        $this->set(compact('welcomemessage'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Welcomemessage id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $welcomemessage = $this->Welcomemessages->get($id);
        if ($this->Welcomemessages->delete($welcomemessage)) {
            $this->Flash->success(__('The welcomemessage has been deleted.'));
        } else {
            $this->Flash->error(__('The welcomemessage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
