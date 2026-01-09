<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\FrozenDate;

class FamhappController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->viewBuilder()->setLayout('famhapp');
        $this->loadModel('Users');
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);

        // Permitir acciones sin pasar por el Auth de los admin
        $this->Auth->allow([
            'home',
            'configuration',
            'logout',
            'registry',
            'registryson',
            'contracts',
            'contractView',
            'profile',
            'adduser',
            'userdetails',
            'rewards',
            'contractadd',
        ]);

        $publicActions = [
            'registry',
        ];

        $action = (string) $this->request->getParam('action');
        if (in_array($action, $publicActions, true)) {
            return;
        }

        $session = $this->request->getSession();
        $famhappUser = $session->read('FamhappUser');

        if (empty($famhappUser)) {
            return $this->redirect([
                'controller' => 'Adminusers',
                'action' => 'login'
            ]);
        }
        $isFather = (int) ($famhappUser['isfather'] ?? 0) === 1;
        $allowedForChild = ['home', 'logout'];

        if (!$isFather && !in_array($action, $allowedForChild, true)) {
            return $this->redirect(['controller' => 'Famhapp', 'action' => 'home']);
        }
    }


    public function home()
    {
        $session = $this->request->getSession();
        $sessionUser = $session->read('FamhappUser') ?: $session->read('Auth.User');

        $this->set('sessionUser', $sessionUser);

        $this->viewBuilder()->setLayout('famhapp');
    }



    /**
     * Registro de nuevo tutor 
     */
    public function registry()
    {
        $this->set('title', __('Registro de tutor'));

        if (!$this->request->is('post')) {
            // Sólo mostramos el formulario
            return;
        }

        $data = $this->request->getData();

        $required = [
            'username',
            'name',
            'lastname',
            'phone',
            'city',
            'email',
            'genre',
            'birthdate',
            'password',
            'password_confirm'
        ];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                $this->Flash->error(__('Por favor, rellena todos los campos obligatorios.'));
                return;
            }
        }


        $today = date('Y-m-d');

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['birthdate'])) {
            $this->Flash->error(__('La fecha de nacimiento no es válida.'));
            return;
        }

        if ($data['birthdate'] > $today) {
            $this->Flash->error(__('La fecha de nacimiento no puede ser posterior a hoy.'));
            return;
        }
        if (empty($data['accept_privacy'])) {
            $this->Flash->error(__('Debes aceptar la Política de privacidad para continuar.'));
            return;
        }


        if ($data['password'] !== $data['password_confirm']) {
            $this->Flash->error(__('Las contraseñas no coinciden.'));
            return;
        }

        // Usuario único
        if ($this->Users->exists(['username' => $data['username']])) {
            $this->Flash->error(__('El nombre de usuario ya está en uso.'));
            return;
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
        $user->password = $data['password'];
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
        $user->devicetype = 'and';
        $user->lastlanguage = 'es';
        $user->pointstosubstract = 0;

        if ($this->Users->save($user)) {
            $this->Flash->success(__('Tu cuenta se ha creado correctamente. Ahora puedes iniciar sesión.'));
            return $this->redirect('/login');
        }

        $this->Flash->error(__('No se ha podido completar el registro. Inténtalo de nuevo.'));
    }

    public function configuration()
    {
        $this->viewBuilder()->setLayout('famhapp');

        $identity = $this->getRequest()->getAttribute('identity');
        $user = null;

        if ($identity) {
            // Authentication plugin
            $user = $identity->getOriginalData() ?: $identity->getIdentifier();
        } else {
            $session = $this->getRequest()->getSession();
            $user = $session->read('Auth.User') ?: $session->read('FamhappUser');
        }

        if (is_object($user)) {
            $user = $user->toArray();
        } elseif (!is_array($user)) {
            $user = [];
        }

        $this->set(compact('user'));
    }

    public function logout()
    {
        $session = $this->getRequest()->getSession();
        $session->destroy();

        // Redirige al login del panel 
        return $this->redirect('/login');
    }

    public function adduser()
    {
        $session = $this->request->getSession();
        $user = $session->read('FamhappUser') ?: $session->read('Auth.User');

        if (empty($user['username'])) {
            return $this->redirect(['action' => 'login']);
        }
        if ((int) ($user['isfather'] ?? 0) !== 1) {
            return $this->redirect(['action' => 'home']);
        }
    }

    public function userdetails(string $username)
    {
        $this->viewBuilder()->setLayout('famhapp');
        $this->set('selectedUsername', $username);
    }













































}
