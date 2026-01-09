<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\View\CellTrait;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    use CellTrait;

    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['usersapp']);
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
        $users = $this->Users->find()->all();

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Levels'],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // …
    public function add()
    {
        $user = $this->Users->newEmptyEntity();

        /*─── listados para los <select> ───*/
        $levels = $this->Users->Levels->find('list', ['limit' => 200])->all();
        $parents = $this->Users
            ->find('list', ['keyField' => 'username', 'valueField' => 'username'])
            ->where(['isfather' => 1])
            ->order(['username' => 'ASC'])
            ->all();

        /*─── procesamos envío ───*/
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            /* 1. normalizamos */
            $data['username'] = mb_strtolower(trim($data['username'] ?? ''));

            /* 2. duplicados */
            $exists = $this->Users->find()
                ->where(['LOWER(Users.username) =' => $data['username']])
                ->count();

            if ($exists) {
                $this->Flash->error(__('El nombre de usuario ya está en uso.'));
            } else {
                /* 3. reglas según rol */
                $isChild = isset($data['role']) && $data['role'] === 'Hijo';

                // e-mail / teléfono se vacían si es hijo
                if ($isChild) {
                    $data['email'] = null;
                    $data['phone'] = null;
                } else {
                    $data['father'] = null;
                }

                /* 4. campos automáticos */
                $data += [
                    'isfather' => $isChild ? 0 : 1,
                    'avatar' => $isChild ? 1 : -1,            // 1 = hijo, -1 = padre
                    'policyagreement' => 1,
                    'allowed' => 1,
                    'fbtoken' => $data['username'] . 'Token',
                    'consequencepoints' => 0,
                    'totalpoints' => $data['rewardpoints'] ?? 0,
                    'pointstosubstract' => 0,
                ];

                /* 5. guardamos */
                $user = $this->Users->patchEntity($user, $data);

                if ($this->Users->save($user)) {
                    $this->Flash->success(__('La operación se ha realizado con éxito.'));
                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('No se pudo crear el usuario. Inténtelo de nuevo.'));
            }
        }

        $this->set(compact('user', 'levels', 'parents'));
    }


    public function login()
    {
        // Si NO es POST, sólo mostramos el formulario (web) o no hacemos nada (API)
        if (!$this->request->is('post')) {
            return;
        }

        $username = trim((string) $this->request->getData('username'));
        $password = (string) $this->request->getData('password');

        $user = $this->Users->find()->where(['username' => $username])->first();

        if (!$user) {
            $response = $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'Code' => 'NOOK',
                    'Response' => 'Usuario o contraseña incorrectos'
                ]));
            return $response;
        }

        if (!(new DefaultPasswordHasher)->check($password, $user->password)) {
            $response = $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'Code' => 'NOOK',
                    'Response' => 'Usuario o contraseña incorrectos'
                ]));
            return $response;
        }

        $now = FrozenTime::now();
        $key = 'thisismykey';

        $payload = [
            'username' => $user->username,
            'email' => $user->email,
            'created' => $now->i18nFormat('yyyy-MM-dd HH:mm:ss'),
        ];

        $tokenstable = TableRegistry::get('Sectokens');
        $token = $tokenstable->newEmptyEntity();
        $token->date = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $token->valid = 1;
        $token->user_username = $user->username;

        if ($tokenstable->save($token)) {
            $jwt = JWT::encode($payload, $key, 'HS256');

            $this->set([
                'Token' => $jwt,
                '_serialize' => ['token']
            ]);
            $this->autoRender = false;

            $response = $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'Code' => 'OK',
                    'Response' => $jwt
                ]));
            return $response;
        }
    }


    public function registerfather()
    {
        if ($this->request->is('post')) {
            $licensestable = TableRegistry::get('Licenses');
            $selectedlicense = $licensestable->find()->where(['Licenses.key' => $this->request->getData('key')])->where(['Licenses.used' => 0])->first();
            if (!$selectedlicense || $selectedlicense == null) {
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El código de licencia no existe o ya está en uso.']));
                //$response = $this->response->withStringBody('El código de licencia no existe o ya está en uso.');
                return $response;
            } else {
                if ($this->Users->find()->where(['username' => trim($this->request->getData('username'))])->count() > 0 || $this->Users->find()->where(['email' => trim($this->request->getData('email'))])->count() > 0) {
                    $response = $this->response->withType('application/json')
                        ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El nombre de usuario o email elegido ya está en uso.']));
                    //$response = $this->response->withStringBody('El nombre de usuario o email elegido ya está en uso.');
                    return $response;
                }
                $user = $this->Users->newEmptyEntity();
                $user->username = $this->request->getData('username');
                $user->level_id = 1;
                $user->email = $this->request->getData('email');
                $user->name = $this->request->getData('name');
                $user->city = $this->request->getData('city');
                $user->lastname = $this->request->getData('lastname');
                $user->genre = $this->request->getData('genre');
                $user->phone = $this->request->getData('phone');
                $user->password = $this->request->getData('password');
                $user->rewardpoints = 0;
                $user->consequencepoints = 0;
                $user->totalpoints = 0;
                $user->isfather = 1;
                $user->father = null;
                $now = FrozenTime::now();
                if ($this->request->getData('birthdate') != '') {
                    $user->birthdate = $this->request->getData('birthdate');
                } else {
                    $user->birthdate = date("Y-m-d");
                }
                if ($this->Users->save($user)) {
                    $selectedlicense->used = 1;
                    $licensestable->save($selectedlicense);
                    $response = $this->response->withType('application/json')
                        ->withStringBody(json_encode(['Code' => 'OK', 'Response' => 'Usuario registrado.']));
                    //$response = $this->response->withStringBody('OK');
                    return $response;
                }
            }

        }
    }

    public function registerson()
    {
        if ($this->request->is('post')) {
            $licensestable = TableRegistry::get('Licenses');
            $selectedlicense = $licensestable->find()->where(['Licenses.key' => $this->request->getData('key')])->where(['Licenses.used' => 0])->first();
            if (!$selectedlicense || $selectedlicense == null) {
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El código de licencia no existe o ya está en uso.']));
                //$response = $this->response->withStringBody('El código de licencia no existe o ya está en uso.');
                return $response;
            } else {
                if ($this->Users->find()->where(['username' => trim($this->request->getData('username'))])->count() > 0 || $this->Users->find()->where(['email' => trim($this->request->getData('email'))])->count() > 0) {
                    $response = $this->response->withType('application/json')
                        ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El nombre de usuario o email elegido ya está en uso.']));
                    //$response = $this->response->withStringBody('El nombre de usuario o email elegido ya está en uso.');
                    return $response;
                }
                $authHeader = $this->request->getHeader('Authorization')[0] ?? '';
                if (str_starts_with($authHeader, 'Bearer ')) {
                    $token = substr($authHeader, 7);
                    $userfather = $this->validateToken($token);
                    $user = $this->Users->newEmptyEntity();
                    $user->username = $this->request->getData('username');
                    $user->level_id = 1;
                    $user->email = $this->request->getData('email');
                    $user->name = $this->request->getData('name');
                    $user->city = $this->request->getData('city');
                    $user->lastname = $this->request->getData('lastname');
                    $user->genre = $this->request->getData('genre');
                    $user->phone = $this->request->getData('phone');
                    $user->password = $this->request->getData('password');
                    $user->rewardpoints = 0;
                    $user->consequencepoints = 0;
                    $user->totalpoints = 0;
                    $user->isfather = 0;
                    $user->father = $userfather->username;
                    $now = FrozenTime::now();
                    if ($this->request->getData('birthdate') != '') {
                        $user->birthdate = $this->request->getData('birthdate');
                    } else {
                        $user->birthdate = date("Y-m-d");
                    }
                    if ($this->Users->save($user)) {
                        $selectedlicense->used = 1;
                        $licensestable->save($selectedlicense);
                        $response = $this->response->withType('application/json')
                            ->withStringBody(json_encode(['Code' => 'OK', 'Response' => 'Usuario registrado.']));
                        //$response = $this->response->withStringBody('OK');
                        return $response;
                    }
                }
            }

        }
    }

    public function register()
    {
        if ($this->request->is('post')) {
            $licensestable = TableRegistry::get('Licenses');
            $selectedlicense = $licensestable->find()->where(['Licenses.key' => $this->request->getData('key')])->where(['Licenses.used' => 0])->first();
            if (!$selectedlicense || $selectedlicense == null) {
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El código de licencia no existe o ya está en uso.']));
                //$response = $this->response->withStringBody('El código de licencia no existe o ya está en uso.');
                return $response;
            } else {
                if ($this->Users->find()->where(['username' => trim($this->request->getData('username'))])->count() > 0 || $this->Users->find()->where(['email' => trim($this->request->getData('email'))])->count() > 0) {
                    $response = $this->response->withType('application/json')
                        ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El nombre de usuario o email elegido ya está en uso.']));
                    //$response = $this->response->withStringBody('El nombre de usuario o email elegido ya está en uso.');
                    return $response;
                }
                $user = $this->Users->newEmptyEntity();
                $user->username = $this->request->getData('username');
                $user->level_id = 1;
                $user->email = $this->request->getData('email');
                $user->name = $this->request->getData('name');
                $user->city = $this->request->getData('city');
                $user->lastname = $this->request->getData('lastname');
                $user->genre = $this->request->getData('genre');
                $user->phone = $this->request->getData('phone');
                $user->password = $this->request->getData('password');
                $user->rewardpoints = 0;
                $user->consequencepoints = 0;
                $user->totalpoints = 0;
                $now = FrozenTime::now();
                if ($this->request->getData('birthdate') != '') {
                    $user->birthdate = $this->request->getData('birthdate');
                } else {
                    $user->birthdate = date("Y-m-d");
                }
                if ($this->Users->save($user)) {
                    $selectedlicense->used = 1;
                    $licensestable->save($selectedlicense);
                    $response = $this->response->withType('application/json')
                        ->withStringBody(json_encode(['Code' => 'OK', 'Response' => 'Usuario registrado.']));
                    //$response = $this->response->withStringBody('OK');
                    return $response;
                }
            }

        }
    }

    public function listsons()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $authHeader = $this->request->getHeader('Authorization')[0] ?? '';
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
                $user = $this->validateToken($token);
                $sonslist = $this->Users->find()->contain(['Contracts', 'Levels'])->where(['isfather' => 0, 'father' => $user->username])->all();
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'OK', 'Response' => $sonslist]));
                return $response;
            }
        }
    }

    public function getnotifs()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $authHeader = $this->request->getHeader('Authorization')[0] ?? '';
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
                $user = $this->validateToken($token);
                $notifstable = TableRegistry::get('NotificationsUsers');
                $notifslist = $notifstable->find()->contain(['Users', 'Notifications'])->where(['Users.father' => $user->username])->all();
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'OK', 'Response' => $notifslist]));
                return $response;
            }
        }
    }

    public function getallcontractsbyson()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $authHeader = $this->request->getHeader('Authorization')[0] ?? '';
            if (str_starts_with($authHeader, 'Bearer ')) {
                $token = substr($authHeader, 7);
                $user = $this->validateToken($token);
                $son = $this->request->getData('username');
                $contractsTable = TableRegistry::get('Contracts');
                $contracts = $contractsTable->find()->contain(['Users', 'States', 'Commitments'])->where(['Users.username' => $son])->all();
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'OK', 'Response' => $contracts]));
                return $response;
            }
        }
    }

    public function exist()
    {
        if ($this->request->is('post')) {
            if ($this->Users->find()->where(['username' => trim($this->request->getData('username'))])->count() > 0) {
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'OK', 'Response' => 'Usuario logueado.']));
                return $response;
            } else {
                $response = $this->response->withType('application/json')
                    ->withStringBody(json_encode(['Code' => 'NOOK', 'Response' => 'El usuario no se encuentra registrado.']));
                return $response;
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(string $username = null)
    {
        if ($username === null) {
            throw new \Cake\Http\Exception\NotFoundException('Usuario no especificado');
        }

        $user = $this->Users->get($username);

        /*  Selects  */
        $levels = $this->Users->Levels->find('list', ['limit' => 200])->all();
        $parents = $this->Users
            ->find('list', ['keyField' => 'username', 'valueField' => 'username'])
            ->where(['isfather' => 1])
            ->order(['username' => 'ASC'])
            ->all();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            /* ─── Campos intocables ─── */
            unset($data['username'], $data['role'], $data['father']);

            /* Puntos recompensa → entero ≥ 0 */
            $data['rewardpoints'] = max(0, (int) ($data['rewardpoints'] ?? 0));

            /* ─ Contraseña ───────────────────────────────────────────── */
            if (empty($data['password'])) {
                // Usuario no la cambió → usamos el hash original
                $data['password'] = $data['password_hash'] ?? $user->password;
            } else {
                // Usuario escribió algo nuevo → lo hasheamos
                $data['password'] = (new \Cake\Auth\DefaultPasswordHasher)->hash($data['password']);
            }
            unset($data['password_hash']);   // limpiamos campo auxiliar


            /* Patcheamos y guardamos */
            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('La operación se ha realizado con éxito.'));
                return $this->redirect(['action' => 'index']);
            }

            /* Si algo falla, mostramos los motivos en un único mensaje */
            $errores = [];
            foreach ($user->getErrors() as $campo => $lista) {
                $errores[] = $campo . ': ' . implode(', ', $lista);
            }
            $this->Flash->error(__('No se pudo guardar el usuario. ') . implode(' | ', $errores));
        }

        $this->set(compact('user', 'levels', 'parents'));
    }



    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // src/Controller/UsersController.php
    public function delete()
    {
        $this->request->allowMethod(['post']);

        $usernames = (array) $this->request->getData('usernames');
        if (empty($usernames)) {
            $this->Flash->error(__('No se seleccionó ningún usuario.'));
            return $this->redirect(['action' => 'index']);
        }

        $todos = $usernames;
        $pendientes = $usernames;     

        while (!empty($pendientes)) {
            $hijos = $this->Users
                ->find()
                ->select('username')
                ->where(['father IN' => $pendientes])
                ->extract('username')
                ->toList();

            $pendientes = array_diff($hijos, $todos); 
            $todos = array_merge($todos, $pendientes); 
        }


        $appdatasUsers = $this->getTableLocator()->get('AppdatasUsers', [
            'className' => 'Cake\ORM\Table',
            'table' => 'appdatas_users'
        ]);
        $sectokens = $this->getTableLocator()->get('Sectokens', [
            'className' => 'Cake\ORM\Table',
            'table' => 'sectokens'
        ]);
        $removes = $this->getTableLocator()->get('Removes', [
            'className' => 'Cake\ORM\Table',
            'table' => 'removes'
        ]);
        $sales = $this->getTableLocator()->get('Sales', [
            'className' => 'Cake\ORM\Table',
            'table' => 'sales'
        ]);

        $connection = $this->Users->getConnection();
        $connection->transactional(function () use ($todos, $appdatasUsers, $sectokens, $removes, $sales) {
            $appdatasUsers->deleteAll(['users_username IN' => $todos]);
            $sectokens->deleteAll(['user_username  IN' => $todos]);
            $removes->deleteAll(['username       IN' => $todos]);
            $sales->deleteAll(['username       IN' => $todos]);

            $this->Users->deleteAll(['username IN' => $todos]);
        });

        $this->Flash->success(__('Se eliminaron {0} usuario(s).', count($todos)));
        return $this->redirect(['action' => 'index']);
    }


}
