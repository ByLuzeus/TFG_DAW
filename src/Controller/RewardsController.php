<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;
/**
 * Rewards Controller
 *
 * @property \App\Model\Table\RewardsTable $Rewards
 * @method \App\Model\Entity\Reward[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RewardsController extends AppController
{
    use CellTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadModel('Rewardsconsequencestypes');
        $this->loadModel('Users');
    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['def_rewards']);
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
        $rewards = $this->Rewards
            ->find()
            ->contain(['Rewardsconsequencestypes'])
            ->all()
            ->toArray();

        $this->set(compact('rewards'));
    }


    /**
     * View method
     *
     * @param string|null $id Reward id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reward = $this->Rewards->get($id, [
            'contain' => ['Rewardsconsequencestypes', 'Commitments', 'Contracts'],
        ]);

        $this->set(compact('reward'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reward = $this->Rewards->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $reward = $this->Rewards->patchEntity($reward, $data);
            if ($this->Rewards->save($reward)) {
                $this->Flash->success(__('La recompensa se ha guardado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar la recompensa. Revisa los campos obligatorios.'));
        }

        $rewardsTypes = $this->Rewardsconsequencestypes
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'description',
            ])
            ->order(['id' => 'ASC'])
            ->toArray();

        // mapeado de puntos
        $typePointsMap = $this->Rewardsconsequencestypes
            ->find()
            ->select(['id', 'points'])
            ->enableHydration(false)
            ->combine('id', 'points')
            ->toArray();

        $usersList = $this->Users
            ->find('list', [
                'keyField' => 'username',
                'valueField' => 'username',
            ])
            ->where(['father IS' => null])
            ->order(['username' => 'ASC'])
            ->toArray();

        $usersList = ['' => __('Sin usuario')] + $usersList;

        $this->set(compact('reward', 'rewardsTypes', 'typePointsMap', 'usersList'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reward id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reward = $this->Rewards->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $reward = $this->Rewards->patchEntity($reward, $data);
            if ($this->Rewards->save($reward)) {
                $this->Flash->success(__('La recompensa se ha actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar la recompensa. Revisa los campos obligatorios.'));
        }

        $rewardsTypes = $this->Rewardsconsequencestypes
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'description',
            ])
            ->order(['id' => 'ASC'])
            ->toArray();

        // Mapeo de los puntos
        $typePointsMap = $this->Rewardsconsequencestypes
            ->find()
            ->select(['id', 'points'])
            ->enableHydration(false)
            ->combine('id', 'points')
            ->toArray();

        $this->set(compact('reward', 'rewardsTypes', 'typePointsMap'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reward id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $ids = $this->request->getData('ids') ?? [];

        if (!empty($ids)) {
            $errors = 0;
            foreach ($ids as $id) {
                try {
                    $reward = $this->Rewards->get($id);
                    if (!$this->Rewards->delete($reward)) {
                        $errors++;
                    }
                } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
                    $errors++;
                }
            }
            if ($errors === 0) {
                $this->Flash->success(__('Las recompensas seleccionadas se han eliminado correctamente.'));
            } elseif ($errors === count($ids)) {
                $this->Flash->error(__('No se pudo eliminar ninguna recompensa. Por favor, inténtalo de nuevo.'));
            } else {
                $this->Flash->error(__('Algunas recompensas no se pudieron eliminar.'));
            }
        } else {
            $this->Flash->error(__('No se seleccionó ninguna recompensa para eliminar.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}