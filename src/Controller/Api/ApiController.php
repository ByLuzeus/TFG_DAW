<?php
declare(strict_types=1);

namespace App\Controller\Api;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Auth\DefaultPasswordHasher;
use Firebase\JWT\JWT;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApiController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Licenses');
        $this->loadModel('NotificationsUsers');
        $this->loadComponent('RequestHandler');
        $this->loadModel('Adminusers');
        $this->loadModel('Contracts');

        // Estos endpoints se consumen desde la demo web y/o desde pantallas públicas
        $this->Auth->allow([
            'registerfather',
            'registrySon',
            'updateProfile',
            'removeRequest',
            'listsons',
            'getNotifsRequest',
        ]);

    }

    /**
     * Helpers para respuestas JSON con el mismo formato
     */

    private function jsonResponse(array $payload, int $status = 200)
    {
        return $this->response
            ->withType('application/json')
            ->withStatus($status)
            ->withStringBody(json_encode($payload, JSON_UNESCAPED_UNICODE));
    }

    private function jsonOk($response, int $status = 200)
    {
        return $this->jsonResponse([
            'Code' => 'OK',
            'Response' => $response,
        ], $status);
    }

    private function jsonError(string $message, int $status = 400)
    {
        return $this->jsonResponse([
            'Code' => 'NOOK',
            'Response' => $message,
        ], $status);
    }

    /**
     * Helper para nombres de usuario duplicado
     */
    private function usernameTaken(string $username): bool
    {
        $u = mb_strtolower(trim($username));

        $existsInUsers = $this->Users->find()
            ->where(['LOWER(Users.username) =' => $u])
            ->count() > 0;

        if ($existsInUsers) {
            return true;
        }

        $existsInAdmins = $this->Adminusers->find()
            ->where(['LOWER(Adminusers.username) =' => $u])
            ->count() > 0;

        return $existsInAdmins;
    }

    /**
     * POST /api/registerfather
     *
     * Params:
     *  username, lastname, email, name, genre, phone, birthdate, city, password
     *
     * Respuesta:
     *  { "Code": "OK",   "Response": "Padre registrado" }
     *  { "Code": "NOOK", "Response": "Mensaje de error" }
     */
    public function registerfather()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();

        $required = [
            'username',
            'lastname',
            'email',
            'name',
            'genre',
            'phone',
            'birthdate',
            'city',
            'password'
        ];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                return $this->jsonError('Faltan campos obligatorios.', 400);
            }
        }

        // Usuario único
        if ($this->Users->exists(['username' => $data['username']])) {
            return $this->jsonError('El nombre de usuario ya está en uso.', 409);
        }

        // Email único 
        if (!empty($data['email']) && $this->Users->exists(['email' => $data['email']])) {
            return $this->jsonError('Ya existe una cuenta con ese correo electrónico.');
        }

        $user = $this->Users->newEmptyEntity();

        $user->username = $data['username'];
        $user->level_id = 1;
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->lastname = $data['lastname'];
        $user->birthdate = $data['birthdate']; 
        $user->genre = $data['genre'];
        $user->phone = $data['phone'];
        $user->password = (string) $data['password'];
        $user->rewardpoints = 0;
        $user->consequencepoints = 0;
        $user->totalpoints = 0;
        $user->city = $data['city'];
        $user->isfather = 1;
        $user->father = null;
        $user->avatar = null;
        $user->policyagreement = 1;
        $user->allowed = 1;
        $user->fbtoken = null;
        $user->devicetype = $data['devicetype'] ?? null; 
        $user->lastlanguage = $data['lastlanguage'] ?? 'es';
        $user->pointstosubstract = 0;

        if ($this->Users->save($user)) {
            return $this->jsonOk('Padre registrado correctamente.');
        }

        return $this->jsonError('No se ha podido registrar al usuario.');
    }

    /**
     * POST /api/registrySon
     *
     * Requisitos:
     *  - Debe haber sesión FamhappUser/Auth.User
     *  - Debe ser padre (isfather = 1)
     *  - La licencia debe existir, estar activa y no estar usada
     */
    public function registrySon()
    {
        $this->request->allowMethod(['post']);

        $session = $this->request->getSession();
        $sessionUser = $session->read('FamhappUser') ?: $session->read('Auth.User');

        if (empty($sessionUser['username'])) {
            return $this->jsonError('No estás autorizado', 401);
        }

        if (empty($sessionUser['isfather']) || (int) $sessionUser['isfather'] !== 1) {
            return $this->jsonError('Acceso denegado', 403);
        }

        $fatherUsername = (string) $sessionUser['username'];
        $father = $this->Users->find()->where(['Users.username' => $fatherUsername])->first();
        if (!$father) {
            return $this->jsonError('Usuario no válido', 401);
        }

        $data = $this->request->getData();
        $required = ['username', 'password', 'name', 'lastname', 'birthdate', 'key'];
        foreach ($required as $field) {
            if (empty($data[$field]) || trim((string) $data[$field]) === '') {
                return $this->jsonError('Faltan campos obligatorios.', 400);
            }
        }

        $kidUsername = trim((string) $data['username']);
        $kidPassword = (string) $data['password'];
        $kidName = trim((string) $data['name']);
        $kidLastname = trim((string) $data['lastname']);
        $kidBirthdateRaw = trim((string) $data['birthdate']);
        $licenseKey = trim((string) $data['key']);

        // Normaliza fecha 
        $kidBirthdate = $kidBirthdateRaw;
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $kidBirthdateRaw)) {
            [$d, $m, $y] = explode('/', $kidBirthdateRaw);
            $kidBirthdate = sprintf('%04d-%02d-%02d', (int) $y, (int) $m, (int) $d);
        }
        $kidUsernameLower = strtolower($kidUsername);

        $existsInUsers = $this->Users->find()
            ->where(['LOWER(Users.username)' => $kidUsernameLower])
            ->count() > 0;

        $existsInAdmins = $this->Adminusers->find()
            ->where(['LOWER(Adminusers.username)' => $kidUsernameLower])
            ->count() > 0;

        if ($existsInUsers || $existsInAdmins) {
            return $this->jsonError('El nombre de usuario ya está en uso.', 409);
        }
        $license = $this->Licenses->find()
            ->where(['Licenses.licensekey' => $licenseKey])
            ->first();

        if (!$license || (int) ($license->active ?? 0) !== 1) {
            return $this->jsonError('La licencia no es válida.', 400);
        }
        if ((int) ($license->used ?? 0) === 1) {
            return $this->jsonError('La licencia ya está usada.', 409);
        }

        $kid = $this->Users->newEmptyEntity();
        $kidData = [
            'username' => $kidUsername,
            'level_id' => 1,
            'email' => null,
            'name' => $kidName,
            'lastname' => $kidLastname,
            'birthdate' => $kidBirthdate,
            'genre' => null,
            'phone' => null,
            'password' => $kidPassword,
            'rewardpoints' => 0,
            'consequencepoints' => 0,
            'totalpoints' => 0,
            'city' => (string) ($father->city ?? ''),
            'isfather' => 0,
            'father' => $fatherUsername,
            'avatar' => 1,
            'policyagreement' => 1,
            'allowed' => 1,
            'fbtoken' => null,
            'devicetype' => null,
            'lastlanguage' => 'es',
            'pointstosubstract' => 0,
        ];

        $kid = $this->Users->patchEntity($kid, $kidData, ['fields' => array_keys($kidData)]);
        if ($kid->hasErrors()) {
            return $this->jsonError('Datos inválidos. Revisa los campos.', 422);
        }

        $conn = $this->Users->getConnection();
        $conn->begin();

        try {
            if (!$this->Users->save($kid)) {
                $conn->rollback();
                return $this->jsonError('No se ha podido añadir el dispositivo.', 500);
            }
            $license->used = 1;
            $license->username = $kidUsername;

            if (!empty($father->email)) {
                $license->email = $father->email;
            }

            if (!$this->Licenses->save($license)) {
                $conn->rollback();
                return $this->jsonError('No se ha podido asociar la licencia.', 500);
            }

            $conn->commit();
            return $this->jsonOk('Usuario añadido correctamente.');
        } catch (\Throwable $e) {
            $conn->rollback();
            return $this->jsonError('Error interno al añadir el dispositivo.', 500);
        }
    }

    public function listsons()
    {
        $this->request->allowMethod(['get']);

        $session = $this->request->getSession();
        $sessionUser = $session->read('FamhappUser') ?: $session->read('Auth.User');

        if (empty($sessionUser['username'])) {
            return $this->jsonError('No estás autorizado', 401);
        }

        $currentUsername = (string) $sessionUser['username'];
        $isFather = !empty($sessionUser['isfather']) && (int) $sessionUser['isfather'] === 1;

        $q = $this->Users->find()
            ->select(['username', 'name', 'lastname', 'avatar', 'rewardpoints'])
            ->enableHydration(false);

        if ($isFather) {
            $q->where(['Users.father' => $currentUsername]);
        } else {
            $q->where(['Users.username' => $currentUsername]);
        }

        $users = $q->orderAsc('Users.name')->all()->toList();

        if (empty($users)) {
            return $this->jsonOk([]);
        }

        $usernames = array_values(array_filter(array_map(fn($u) => $u['username'] ?? null, $users)));

        $now = FrozenTime::now();
        $activeByUser = [];

        if (!empty($usernames)) {
            $contracts = $this->Contracts->find()
                ->select(['username', 'enddate'])
                ->where([
                    'Contracts.username IN' => $usernames,
                    'Contracts.active' => 1,
                    'Contracts.ended' => 0,
                    'Contracts.enddate >=' => $now,
                ])
                ->orderDesc('Contracts.enddate')
                ->enableHydration(false)
                ->all()
                ->toList();

            foreach ($contracts as $c) {
                $u = (string) ($c['username'] ?? '');
                if ($u === '' || isset($activeByUser[$u])) {
                    continue;
                }
                $end = $c['enddate'] ?? null;
                if ($end instanceof \Cake\I18n\FrozenTime || $end instanceof \Cake\I18n\Time) {
                    $endStr = $end->i18nFormat('yyyy-MM-dd');
                } else {
                    $endStr = is_string($end) ? substr(str_replace('T', ' ', $end), 0, 10) : null;
                }

                $activeByUser[$u] = $endStr;
            }
        }

        $out = array_map(function ($u) use ($activeByUser) {
            $username = (string) ($u['username'] ?? '');
            $endStr = $activeByUser[$username] ?? null;

            $rewardpoints = $u['rewardpoints'] ?? 0;
            $rewardpointsNum = is_numeric($rewardpoints) ? (float) $rewardpoints : 0;

            return [
                'username' => $username,
                'name' => (string) ($u['name'] ?? ''),
                'lastname' => (string) ($u['lastname'] ?? ''),
                'avatar' => $u['avatar'] ?? null,
                'rewardpoint' => $rewardpointsNum,  
                'rewardpoints' => $rewardpointsNum,  
                'contract_active' => $endStr !== null,
                'contract_enddate' => $endStr,
            ];
        }, $users);

        return $this->jsonOk($out);
    }


    public function getNotifsRequest()
    {
        $this->request->allowMethod(['get']);

        $session = $this->request->getSession();
        $sessionUser = $session->read('FamhappUser') ?: $session->read('Auth.User');

        if (empty($sessionUser['username'])) {
            return $this->jsonError('No estás autorizado', 401);
        }

        $currentUsername = $sessionUser['username'];
        $isFather = !empty($sessionUser['isfather']) && (int) $sessionUser['isfather'] === 1;

        $q = $this->NotificationsUsers->find()
            ->select([
                'NotificationsUsers.username',
                'NotificationsUsers.notificationdate',
                'NotificationsUsers.notification_id',
            ])
            ->contain([
                'Users' => function ($qq) {
                    return $qq->select(['username', 'father']);
                }
            ])
            ->orderDesc('NotificationsUsers.notificationdate')
            ->limit(25)
            ->enableHydration(false);

        if ($isFather) {
            $q->where(['Users.father' => $currentUsername]);
        } else {
            $q->where(['NotificationsUsers.username' => $currentUsername]);
        }

        $rows = $q->all()->toList();

        $out = array_map(function ($r) {
            $date = $r['notificationdate'] ?? null;
            if ($date instanceof \Cake\I18n\FrozenTime || $date instanceof \Cake\I18n\Time) {
                $date = $date->i18nFormat('yyyy-MM-dd HH:mm:ss');
            } elseif (is_string($date)) {
                $date = str_replace('T', ' ', substr($date, 0, 19));
            }

            return [
                'username' => (string) ($r['username'] ?? ''),
                'notificationdate' => $date,
                'notification_id' => (int) ($r['notification_id'] ?? 0),
            ];
        }, $rows);

        return $this->jsonOk($out);
    }

    public function removeRequest()
    {
        $this->request->allowMethod(['post']);

        $this->viewBuilder()->setClassName('Json');

        $session = $this->getRequest()->getSession();
        $famhappUser = $session->read('FamhappUser');

        if (empty($famhappUser) || empty($famhappUser['username'])) {
            $this->response = $this->response->withStatus(401);
            $this->set([
                'success' => false,
                'message' => 'No autenticado.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $username = (string) $famhappUser['username'];

        $this->loadModel('Removes');

        $data = (array) $this->getRequest()->getData();

        $observations = isset($data['observations']) ? (string) $data['observations'] : '';
        $observations = trim($observations);
        $observations = mb_substr($observations, 0, 1000);

        if ($observations === '' || mb_strlen($observations) < 5) {
            $this->response = $this->response->withStatus(422);
            $this->set([
                'success' => false,
                'message' => 'Debes escribir un motivo (mínimo 5 caracteres).',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $keepanonymous = !empty($data['keepanonymous']) ? 1 : 0;

        $remove = $this->Removes->newEmptyEntity();
        $remove = $this->Removes->patchEntity($remove, [
            'username' => $username,
            'observations' => $observations,
            'keepanonymous' => $keepanonymous,
        ], [
            'fields' => ['username', 'observations', 'keepanonymous']
        ]);

        if ($this->Removes->save($remove)) {
            $this->set([
                'success' => true,
                'message' => 'Solicitud enviada correctamente.',
                'data' => [
                    'id' => $remove->id ?? null,
                    'username' => $username,
                    'keepanonymous' => $keepanonymous,
                ],
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message', 'data']);
            return;
        }

        $this->response = $this->response->withStatus(422);
        $this->set([
            'success' => false,
            'message' => 'No se pudo enviar la solicitud.',
            'errors' => $remove->getErrors(),
        ]);
        $this->viewBuilder()->setOption('serialize', ['success', 'message', 'errors']);
    }


    public function updateProfile()
    {
        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');

        $session = $this->getRequest()->getSession();
        $famhappUser = $session->read('FamhappUser');

        if (empty($famhappUser) || empty($famhappUser['username'])) {
            $this->response = $this->response->withStatus(401);
            $this->set([
                'success' => false,
                'message' => 'No autenticado.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $username = (string) $famhappUser['username'];

        $this->loadModel('Users');

        try {
            $user = $this->Users->get($username);
        } catch (\Exception $e) {
            $this->response = $this->response->withStatus(404);
            $this->set([
                'success' => false,
                'message' => 'Usuario no encontrado.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $data = (array) $this->getRequest()->getData();

        $name = trim((string) ($data['name'] ?? ''));
        $lastname = trim((string) ($data['lastname'] ?? ''));
        $phone = trim((string) ($data['phone'] ?? ''));
        $city = trim((string) ($data['city'] ?? ''));
        $birthdate = trim((string) ($data['birthdate'] ?? ''));

        if ($name === '' || $lastname === '' || $phone === '' || $city === '' || $birthdate === '') {
            $this->response = $this->response->withStatus(422);
            $this->set([
                'success' => false,
                'message' => 'Completa todos los campos obligatorios.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }
        $birthdateRaw = $birthdate;
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $birthdateRaw)) {
        } elseif (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $birthdateRaw)) {
            [$a, $b, $y] = array_map('intval', explode('/', $birthdateRaw));
            if ($a > 12) {         
                $d = $a;
                $m = $b;
            } elseif ($b > 12) {     
                $m = $a;
                $d = $b;
            } else {                 
                $d = $a;
                $m = $b;
            }
            $birthdate = sprintf('%04d-%02d-%02d', $y, $m, $d);
        } elseif (preg_match('/^\d{1,2}-\d{1,2}-\d{4}$/', $birthdateRaw)) {
            [$a, $b, $y] = array_map('intval', explode('-', $birthdateRaw));
            if ($a > 12) {
                $d = $a;
                $m = $b;
            } elseif ($b > 12) {
                $m = $a;
                $d = $b;
            } else {
                $d = $a;
                $m = $b;
            }
            $birthdate = sprintf('%04d-%02d-%02d', $y, $m, $d);
        } else {
            $this->response = $this->response->withStatus(422);
            $this->set([
                'success' => false,
                'message' => 'Formato de fecha no válido.',
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message']);
            return;
        }

        $password = (string) ($data['password'] ?? '');
        $passwordConfirm = (string) ($data['password_confirm'] ?? '');

        if ($password !== '' || $passwordConfirm !== '') {
            if ($password === '' || $passwordConfirm === '') {
                $this->response = $this->response->withStatus(422);
                $this->set([
                    'success' => false,
                    'message' => 'Para cambiar la contraseña, rellena ambos campos.',
                ]);
                $this->viewBuilder()->setOption('serialize', ['success', 'message']);
                return;
            }

            if ($password !== $passwordConfirm) {
                $this->response = $this->response->withStatus(422);
                $this->set([
                    'success' => false,
                    'message' => 'Las contraseñas no coinciden.',
                ]);
                $this->viewBuilder()->setOption('serialize', ['success', 'message']);
                return;
            }
        }

        $patchData = [
            'name' => $name,
            'lastname' => $lastname,
            'phone' => $phone,
            'city' => $city,
            'birthdate' => $birthdate,
        ];

        if ($password !== '') {
            $patchData['password'] = $password;
        }

        $user = $this->Users->patchEntity($user, $patchData, [
            'fields' => ['name', 'lastname', 'phone', 'city', 'birthdate', 'password'],
        ]);

        if ($user->hasErrors()) {
            $this->response = $this->response->withStatus(422);
            $this->set([
                'success' => false,
                'message' => 'Datos inválidos.',
                'errors' => $user->getErrors(),
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message', 'errors']);
            return;
        }

        if ($this->Users->save($user)) {
            $famhappUser['name'] = $user->name;
            $famhappUser['lastname'] = $user->lastname;
            $famhappUser['phone'] = $user->phone;
            $famhappUser['city'] = $user->city;
            $famhappUser['birthdate'] = (string) $user->birthdate;
            $session->write('FamhappUser', $famhappUser);

            $this->set([
                'success' => true,
                'message' => 'Datos actualizados correctamente.',
                'data' => [
                    'username' => $username,
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'phone' => $user->phone,
                    'city' => $user->city,
                    'birthdate' => (string) $user->birthdate,
                ],
            ]);
            $this->viewBuilder()->setOption('serialize', ['success', 'message', 'data']);
            return;
        }

        $this->response = $this->response->withStatus(500);
        $this->set([
            'success' => false,
            'message' => 'No se pudieron guardar los datos.',
        ]);
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);
    }

    public function userdetails()
    {
        $this->request->allowMethod(['get']);
        $this->viewBuilder()->setClassName('Json');

        $this->loadModel('Users');
        $this->loadModel('Contracts');
        $this->loadModel('Levels');

        $pass = (array) $this->request->getParam('pass');
        $username = $pass[0] ?? null;

        if (empty($username)) {
            $this->set([
                'Code' => 'ERROR',
                'Response' => 'Falta username',
                '_serialize' => ['Code', 'Response']
            ]);
            return;
        }

        $session = $this->request->getSession();
        $viewer = $session->read('FamhappUser') ?: $session->read('Auth.User');

        if (empty($viewer['username'])) {
            $this->set([
                'Code' => 'ERROR',
                'Response' => 'No autenticado',
                '_serialize' => ['Code', 'Response']
            ]);
            return;
        }

        $viewerUsername = (string) $viewer['username'];
        $viewerIsFather = (int) ($viewer['isfather'] ?? 0) === 1;

        $user = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        if (!$user) {
            $this->set([
                'Code' => 'ERROR',
                'Response' => 'Usuario no encontrado',
                '_serialize' => ['Code', 'Response']
            ]);
            return;
        }

        $isSelf = ($viewerUsername === $username);
        $isChildOfViewer = (!empty($user->father) && $user->father === $viewerUsername);

        if (!$isSelf && !($viewerIsFather && $isChildOfViewer)) {
            $this->set([
                'Code' => 'ERROR',
                'Response' => 'No autorizado',
                '_serialize' => ['Code', 'Response']
            ]);
            return;
        }

        $level = null;
        if (!empty($user->level_id)) {
            $lvl = $this->Levels->find()->where(['id' => $user->level_id])->first();
            if ($lvl) {
                $level = [
                    'id' => $lvl->id,
                    'description' => $lvl->description,
                    'pointsprice' => $lvl->pointsprice,
                ];
            }
        }

        // Historial contratos
        $contracts = $this->Contracts->find()
            ->select(['id', 'startdate', 'enddate', 'breaches', 'ended', 'active'])
            ->where(['username' => $username])
            ->order(['startdate' => 'DESC'])
            ->all()
            ->map(function ($c) {
                return [
                    'id' => $c->id,
                    'startdate' => $c->startdate,
                    'enddate' => $c->enddate,
                    'breaches' => (int) ($c->breaches ?? 0),
                    'ended' => (int) ($c->ended ?? 0),
                    'active' => (int) ($c->active ?? 0),
                ];
            })
            ->toList();

        $rewardpoints = $user->rewardpoint ?? $user->rewardpoints ?? 0;

        $this->set([
            'Code' => 'OK',
            'Response' => [
                'user' => [
                    'username' => $user->username,
                    'name' => $user->name,
                    'lastname' => $user->lastname,
                    'avatar' => $user->avatar,
                    'rewardpoints' => (int) $rewardpoints,
                    'level_id' => $user->level_id,
                ],
                'level' => $level,
                'contracts' => $contracts
            ],
            '_serialize' => ['Code', 'Response']
        ]);
    }










































}
