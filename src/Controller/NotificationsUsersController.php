<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * NotificationsUsers Controller
 *
 * @property \App\Model\Table\NotificationsUsersTable $NotificationsUsers
 * @method \App\Model\Entity\NotificationsUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class NotificationsUsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Notifications'],
        ];
        $notificationsUsers = $this->paginate($this->NotificationsUsers);

        $this->set(compact('notificationsUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Notifications User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $notificationsUser = $this->NotificationsUsers->get($id, [
            'contain' => ['Notifications'],
        ]);

        $this->set(compact('notificationsUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $notificationsUser = $this->NotificationsUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $notificationsUser = $this->NotificationsUsers->patchEntity($notificationsUser, $this->request->getData());
            if ($this->NotificationsUsers->save($notificationsUser)) {
                $this->Flash->success(__('The notifications user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notifications user could not be saved. Please, try again.'));
        }
        $notifications = $this->NotificationsUsers->Notifications->find('list', ['limit' => 200])->all();
        $this->set(compact('notificationsUser', 'notifications'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Notifications User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $notificationsUser = $this->NotificationsUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $notificationsUser = $this->NotificationsUsers->patchEntity($notificationsUser, $this->request->getData());
            if ($this->NotificationsUsers->save($notificationsUser)) {
                $this->Flash->success(__('The notifications user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The notifications user could not be saved. Please, try again.'));
        }
        $notifications = $this->NotificationsUsers->Notifications->find('list', ['limit' => 200])->all();
        $this->set(compact('notificationsUser', 'notifications'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Notifications User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notificationsUser = $this->NotificationsUsers->get($id);
        if ($this->NotificationsUsers->delete($notificationsUser)) {
            $this->Flash->success(__('The notifications user has been deleted.'));
        } else {
            $this->Flash->error(__('The notifications user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
