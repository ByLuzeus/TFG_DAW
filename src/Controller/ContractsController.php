<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Auth\DefaultPasswordHasher;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Cake\View\CellTrait;

/**
 * Contracts Controller
 *
 * @property \App\Model\Table\ContractsTable $Contracts
 * @method \App\Model\Entity\Contract[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContractsController extends AppController
{
    use CellTrait;
    public function initialize(): void
    {
        parent::initialize();
    }
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['contracts']);
        $this->set(['menuadmin' => $menuadmin]);
        $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
        $this->set(['headeradmin' => $headeradmin]);
    }
    public function validateToken($token)
    {
        $key = 'thisismykey';
        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\UnexpectedValueException $e) {
            die('UnexpectedValueException: ' . $e->getMessage());
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            die('SignatureInvalidException: ' . $e->getMessage());
        } catch (\Firebase\JWT\BeforeValidException $e) {
            die('BeforeValidException: ' . $e->getMessage());
        } catch (\Firebase\JWT\ExpiredException $e) {
            die('ExpiredException: ' . $e->getMessage());
        } catch (\Exception $e) {
            die('General Exception: ' . $e->getMessage());
        }
        $sectokensTable = TableRegistry::get('Sectokens');
        // Busca el token en la base de datos
        $tokenRecord = $sectokensTable->find()
            ->where([
                'user_username' => $decoded->username,
                'date' => $decoded->created,
                'valid' => 1
            ])
            ->first();
        // Si el token existe en la base de datos y es válido, devuelve el usuario
        if ($tokenRecord) {
            $user = $this->Users->find()->where(['username' => $decoded->username])->first();
            return $user;
            //Si no, devuelve un mensaje de error de No autorizado 
        } else {
            $this->response = $this->response->withStatus(401)
                ->withType('application/json')
                ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'No estás autorizado']));
            return $this->response;
        }
    }

    public function newcontractforson()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $authHeader = $this->request->getHeader('Authorization')[0] ?? '';
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
                $user = $this->validateToken($token);
                $sonname = $this->request->getData('username');
                $userstable = TableRegistry::get('Users');
                $son = $userstable->find()->contain(['Users'])->where(['Users.username' => $sonname])->first();
                $now = FrozenTime::now();
                $startdate = $now->addDay(1)->startOfDay();
                $enddate = $startdate->addDays(7);

                if ($son->father == $user->username) {
                    $contract = $this->Contracts->newEmptyEntity();
                    $contract->username = $sonname;
                    $contract->state_id = 4;
                    $contract->parentagreement = 1;
                    $contract->childagreement = 1;
                    $contract->ended = 0;
                    $contract->active = 0;
                    $contract->breaches = 0;
                    $contract->contractdate = $now->i18nFormat("yyyy-MM-dd HH:mm:ss");
                    $contract->startdate = $startdate->i18nFormat("yyyy-MM-dd HH:mm:ss");
                    $contract->enddate = $enddate->i18nFormat("yyyy-MM-dd HH:mm:ss");
                    $commitments = $this->request->getData('commitments');
                    $rewards = $this->request->getData('rewards');
                    if ($this->Contracts->save($contract)) {
                        //TODO:COMRPOBAR
                        if ($commitments != NULL && !empty($commitments)) {
                            $commitmentstable = TableRegistry::get('CommitmentsContracts');
                            foreach ($commitments as $commitment) {
                                $newcommitment = $commitmentstable->newEmptyEntity();
                                $newcommitment->state_id = 4;
                                $newcommitment->commitment_id = $commitment['type'];
                                $newcommitment->contract_id = $contract->id;
                                $newcommitment->packagename = $commitment['packagename'];
                                $newcommitment->starttime = $commitment['starttime'];
                                $newcommitment->endtime = $commitment['endtime'];
                                $newcommitment->allowedtime = $commitment['allowedtime'];
                                $newcommitment->allowedunlocks = $commitment['allowedunlocks'];
                                $newcommitment->exceedtime = 0;
                                $newcommitment->eceedunlocks = 0;
                                $newcommitment->totalbreaches = 0;
                                $commitmentstable->save($newcommitment);
                                $commitmentsDetailstable = TableRegistry::get('CommitmentscontractsDetails');
                                for ($i = 0; $i < 7; $i++) {
                                    $detail = $commitmentsDetailstable->newEmptyEntity();
                                    $detail->status_id = 4;
                                    $detail->commitmentcontract_id = $newcommitment->id;
                                    $detail->exceededtime = 0;
                                    $detail->totalbreaches = 0;
                                    $dayofcontract = $startdate->addDays($i);
                                    $detail->mydate = $dayofcontract;
                                    $commitmentsDetailstable->save($detail);
                                }
                            }
                        }
                        //TODO:RECOMPENSAS
                        /* if($rewards != NULL && !empty($rewards)){
                            foreach ($rewards as $reward) {
                                if ($reward['contract_id'] != ""){
                                    $rewardstable = TableRegistry::get('RewardsContracts');
                                    $newreward =  $rewardstable->newEmptyEntity();
                                    $newreward->reward_id = $reward['reward_id'];
                                    $newreward->contract_id = $contract->id;
                                    $newreward->state = $reward['state'];
                                    $rewardstable->save($newreward);
                                } else {
                                    $rewardstable = TableRegistry::get('RewardsCommitments');
                                    $newreward =  $rewardstable->newEmptyEntity();
                                    $newreward->rewardscontract_id = $reward['reward_id'];
                                    $newreward->contract_id = $contract->id;
                                    $newreward->state = $reward['state'];
                                    $rewardstable->save($newreward);
                                }
                            }
                        } */
                        $response = $this->response->withType('application/json')
                            ->withStringBody(json_encode(['Code' => 'OK', 'Response' => $contract]));
                        return $response;
                    } else {
                        $response = $this->response->withType('application/json')
                            ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => "No se ha podido crear el contrato."]));
                        return $response;
                    }
                } else {
                    $response = $this->response->withType('application/json')
                        ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => "No puedes crear un contrato para ese usuario."]));
                    return $response;
                }
            }
        }
    }

    public function getallcontractsforson()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $authHeader = $this->request->getHeader('Authorization')[0] ?? '';
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
                $user = $this->validateToken($token);
                $contractsTable = TableRegistry::get('Contracts');
                $contracts = $contractsTable->find()->contain(['Users', 'States', 'Commitmentscontracts' => ['Details']])->where(['Users.username' => $user['username']])->all();
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'OK', 'Response' => $contracts]));
                return $response;
            }
        }
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $contracts = $this->Contracts->find()->contain(['States'])->all();
        $this->set(compact('contracts'));
    }


    /**
     * View method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */    
    public function view($id = null)
    {
        $contract = $this->Contracts->get($id, [
            'contain' => [
                'States',       
                'Commitments',   
            ],
        ]);

        $this->set(compact('contract'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contract = $this->Contracts->newEmptyEntity();
        if ($this->request->is('post')) {
            $contract = $this->Contracts->patchEntity($contract, $this->request->getData());
            if ($this->Contracts->save($contract)) {
                $this->Flash->success(__('The contract has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The contract could not be saved. Please, try again.'));
        }
        $states = $this->Contracts->States->find('list', ['limit' => 200])->all();
        $commitments = $this->Contracts->Commitments->find('list', ['limit' => 200])->all();
        $rewards = $this->Contracts->Rewards->find('list', ['limit' => 200])->all();
        $this->set(compact('contract', 'states', 'commitments', 'rewards'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // src/Controller/ContractsController.php
    public function edit($id = null)
    {
        $contract = $this->Contracts->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $festivities = [];
            foreach (range(1, 7) as $d) {
                $field = "festivity_$d";
                if (!empty($data[$field]) && $data[$field] === '1') {
                    $festivities[] = (string) $d;
                }
                unset($data[$field]);             
            }
            $data['festivities'] = $festivities ? implode('-', $festivities) : null;

    
            foreach (['ended', 'active'] as $boolField) {
                if (isset($data[$boolField])) {
                    $data[$boolField] = $data[$boolField] === '1' ? 1 : 0;
                }
            }

            unset($data['lastupdate']);

            $contract = $this->Contracts->patchEntity($contract, $data);
            $contract->festivities = $data['festivities'];   // asegura su asignación


            if (!$contract->getErrors() && $this->Contracts->save($contract)) {
                $this->Flash->success(__('El contrato se ha guardado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El contrato no pudo guardarse. Inténtalo de nuevo.'));
        }

        $states = $this->Contracts->States
            ->find('list', [
                'keyField' => 'id',
                'valueField' => function ($row) {
                    return "{$row->id} - {$row->description}";
                },
            ])
            ->order(['id' => 'ASC'])
            ->toArray();

        $this->set(compact('contract', 'states'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Contract id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $ids = $this->request->getData('ids');

        if (empty($ids)) {
            $this->Flash->error(__('Debe seleccionar al menos un contrato.'));
        } else {
            $count = $this->Contracts->deleteAll(['id IN' => $ids]);
            if ($count) {
                $this->Flash->success(__('Se han eliminado {0} contrato(s).', $count));
            } else {
                $this->Flash->error(__('No se pudieron eliminar los contratos.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }
}
