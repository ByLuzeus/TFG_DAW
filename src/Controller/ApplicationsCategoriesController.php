<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ApplicationsCategories Controller
 *
 * @property \App\Model\Table\ApplicationsCategoriesTable $ApplicationsCategories
 * @method \App\Model\Entity\ApplicationsCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApplicationsCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $applicationsCategories = $this->paginate($this->ApplicationsCategories);

        $this->set(compact('applicationsCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Applications Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $applicationsCategory = $this->ApplicationsCategories->get($id, [
            'contain' => ['Categories'],
        ]);

        $this->set(compact('applicationsCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $applicationsCategory = $this->ApplicationsCategories->newEmptyEntity();
        if ($this->request->is('post')) {
            $applicationsCategory = $this->ApplicationsCategories->patchEntity($applicationsCategory, $this->request->getData());
            if ($this->ApplicationsCategories->save($applicationsCategory)) {
                $this->Flash->success(__('The applications category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The applications category could not be saved. Please, try again.'));
        }
        $categories = $this->ApplicationsCategories->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('applicationsCategory', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Applications Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $applicationsCategory = $this->ApplicationsCategories->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $applicationsCategory = $this->ApplicationsCategories->patchEntity($applicationsCategory, $this->request->getData());
            if ($this->ApplicationsCategories->save($applicationsCategory)) {
                $this->Flash->success(__('The applications category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The applications category could not be saved. Please, try again.'));
        }
        $categories = $this->ApplicationsCategories->Categories->find('list', ['limit' => 200])->all();
        $this->set(compact('applicationsCategory', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Applications Category id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $applicationsCategory = $this->ApplicationsCategories->get($id);
        if ($this->ApplicationsCategories->delete($applicationsCategory)) {
            $this->Flash->success(__('The applications category has been deleted.'));
        } else {
            $this->Flash->error(__('The applications category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
