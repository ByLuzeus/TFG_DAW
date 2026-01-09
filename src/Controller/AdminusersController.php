<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Network\Exception\NotFoundException;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Adminusers Controller
 *
 * @property \App\Model\Table\UsersTable $Adminusers
 */
class AdminusersController extends AppController
{

    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
        $this->set(['headeradmin' => $headeradmin]);
        $this->Auth->allow(['forgotpass', 'resetpsw', 'login']);
    }

    /*
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {

        $menuadmin = $this->cell('Menuadmin', ['usuarios-index']);
        $this->set(['menuadmin' => $menuadmin]);

        $users = $this->Adminusers->find()->contain(['Contacts'])->where(['role !=' => 'superadmin'])->all();

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }


    public function view($id = null)
    {


        $menuadmin = $this->cell('Menuadmin', ['usuarios-index']);
        $this->set(['menuadmin' => $menuadmin]);



        $user = $this->Adminusers->get($id, [
            'contain' => ['Multimedia', 'Contacts' => ['Networks']]
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }


    public function add()
    {


        $menuadmin = $this->cell('Menuadmin', ['usuarios-add']);
        $this->set(['menuadmin' => $menuadmin]);

        $mediatable = TableRegistry::get('Multimedia');
        $imageset = $mediatable->find()->where(['id >' => 0])->where(['mytype' => 'image'])->order(['id' => 'DESC'])->all();
        $this->set('imageset', $imageset);


        if ($this->request->is('post')) {


            //Recogemos los datos de usuario
            $user = $this->Adminusers->newEmptyEntity();
            $user->username = $this->request->getData('username');
            $user->password = $this->request->getData('password');
            $now = Time::now();
            $user->created = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $user->role = $this->request->getData('rol');
            $user->name = $this->request->getData('nombre');
            $user->lastname = $this->request->getData('apellidos');

            //Recogemos los datos de contacto
            $contactotable = TableRegistry::get('Contacts');
            $contacto = $contactotable->newEmptyEntity();
            $contacto->address = $this->request->getData('direccion');
            $contacto->email = $this->request->getData('email');
            $contacto->city = $this->request->getData('ciudad');
            $contacto->state = $this->request->getData('provincia');
            $contacto->country = $this->request->getData('pais');
            $contacto->cp = $this->request->getData('cp');
            $contacto->tlfn = $this->request->getData('tlfn');
            $contacto->tlfn2 = $this->request->getData('tlfn2');
            $contacto->fax = $this->request->getData('fax');
            $contacto->latitud = $this->request->getData('latitud');
            $contacto->longitud = $this->request->getData('longitud');

            if (trim($user->username) == '' || trim($user->password) == '' || trim($user->role) == '' || trim($contacto->email) == '') {
                $this->Flash->error(__('Rellena los datos obligatorios'));
                return;
            }

            if (trim($user->username) == '' || $this->Adminusers->find()->where(['username' => trim($user->username)])->count() > 0) {
                $this->Flash->error(__('El nombre de usuario ya está en uso. Escoja otro.'));
                return;
            }

            if (trim($contacto->email) == '' || $this->Adminusers->find()->contain(['Contacts'])->where(['email' => trim($contacto->email)])->count() > 0) {
                $this->Flash->error(__('La cuenta de email ya está en uso. Escoja otra.'));
                return;
            }




            $laimagen = $this->request->getData('imagen-main');
            if ($laimagen == null || $laimagen == '') {
                $user->multimedia_id = constant("ID_DEFAULT_USER_IMAGE");
            } else {
                $user->multimedia_id = $laimagen;
            }


            $contactotable->save($contacto);
            $user->contact_id = $contacto->id;


            if ($this->Adminusers->save($user)) {
                $logs = TableRegistry::get('Logs');
                $log = $logs->newEmptyEntity();
                $log->username = $this->Auth->user('username');
                $log->description = $this->Auth->user('username') . " ha creado el usuario " . $user->username;
                $logs->save($log);
                $this->Flash->success(__('Usuario guardado.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Error guardando usuario'));


        }
    }



    public function edit($id)
    {

        if ($this->Auth->user()['id'] == $id) {
            $menuadmin = $this->cell('Menuadmin', ['usuarios-mi-perfil']);
            $this->set(['menuadmin' => $menuadmin]);
        } else {
            $menuadmin = $this->cell('Menuadmin', ['usuarios-index']);
            $this->set(['menuadmin' => $menuadmin]);
        }

        $user = $this->Adminusers->get($id, [
            'contain' => ['Multimedia', 'Contacts' => ['Networks']]
        ]);

        $this->set('user', $user);


        $mediatable = TableRegistry::get('Multimedia');
        $imageset = $mediatable->find()->where(['id >' => 0])->where(['mytype' => 'image'])->order(['id' => 'DESC'])->all();
        $this->set('imageset', $imageset);


        $networkstable = TableRegistry::get('Networks');
        $networksset = $networkstable->find()->order(['name' => 'ASC'])->all();
        $this->set('networksset', $networksset);


        if ($this->request->is('post')) {


            //Recogemos los datos de usuario

            $user->username = $this->request->getData('username');
            if (trim($this->request->getData('password')) != '') {
                $user->password = $this->request->getData('password');
            }
            $now = Time::now();
            $user->created = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $user->role = $this->request->getData('rol');
            $user->name = $this->request->getData('nombre');
            $user->lastname = $this->request->getData('apellidos');

            //Recogemos los datos de contacto
            $contactotable = TableRegistry::get('Contacts');
            $contacto = $contactotable->get($user->contact_id);
            $contacto->address = $this->request->getData('direccion');
            $contacto->email = $this->request->getData('email');
            $contacto->city = $this->request->getData('ciudad');
            $contacto->state = $this->request->getData('provincia');
            $contacto->country = $this->request->getData('pais');
            $contacto->cp = $this->request->getData('cp');
            $contacto->tlfn = $this->request->getData('tlfn');
            $contacto->tlfn2 = $this->request->getData('tlfn2');
            $contacto->fax = $this->request->getData('fax');
            $contacto->latitud = $this->request->getData('latitud');
            $contacto->longitud = $this->request->getData('longitud');

            if (trim($user->username) == '' || trim($user->password) == '' || trim($user->role) == '' || trim($contacto->email) == '') {
                $this->Flash->error(__('Rellena los datos obligatorios'));
                return;
            }

            if (trim($user->username) == '' || $this->Adminusers->find()->where(['Adminusers.id !=' => $id])->where(['username' => trim($user->username)])->count() > 0) {
                $this->Flash->error(__('El nombre de usuario ya está en uso. Escoja otro.'));
                return;
            }

            if (trim($contacto->email) == '' || $this->Adminusers->find()->where(['Adminusers.id !=' => $id])->contain(['Contacts'])->where(['email' => trim($contacto->email)])->count() > 0) {
                $this->Flash->error(__('La cuenta de email ya está en uso. Escoja otra.'));
                return;
            }


            $laimagen = $this->request->getData('imagen-main');
            if ($laimagen == null || $laimagen == '') {
                $user->multimedia_id = constant("ID_DEFAULT_USER_IMAGE");
            } else {
                $user->multimedia_id = $laimagen;
            }


            $contactotable->save($contacto);


            $contactnetworktable = TableRegistry::get('ContactsNetworks');
            $networkseliminar = $contactnetworktable->find()->where(['contact_id' => $user->contact->id])->all();
            foreach ($networkseliminar as $netaborrar) {
                $contactnetworktable->delete($netaborrar);
            }


            $networks_ids = $this->request->getData('networks_ids');
            $networks_urls = $this->request->getData('networks_urls');

            if ($networks_ids != null) {
                for ($i = 0; $i < count($networks_ids); $i++) {
                    $contactnetwork = $contactnetworktable->newEmptyEntity();
                    $contactnetwork->contact_id = $contacto->id;
                    $contactnetwork->url = $networks_urls[$i];
                    $contactnetwork->network_id = $networks_ids[$i];
                    $contactnetworktable->save($contactnetwork);
                }
            }


            if ($this->Adminusers->save($user)) {
                $logs = TableRegistry::get('Logs');
                $log = $logs->newEmptyEntity();
                $log->username = $this->Auth->user('username');
                $log->description = $this->Auth->user('username') . " ha editado el usuario " . $user->username;
                $logs->save($log);
                $this->Flash->success(__('Usuario guardado.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Error guardando usuario'));


        }
    }


    public function delete()
    {

        $eliminados = false;
        if ($this->request->is('post')) {
            $ids = $this->request->getData('ids');

            foreach ($ids as $id) {

                if ($this->Auth->user('id') == $id) {
                    $this->Flash->error(__('No puedes eliminar tu propio usuario'));
                    continue;

                }

                $user = $this->Adminusers->get($id);
                $nombre = $user->username;
                $contactotable = TableRegistry::get('Contacts');
                $contacto = $contactotable->get($user->contact_id);


                $contactnetworktable = TableRegistry::get('ContactsNetworks');
                $networkseliminar = $contactnetworktable->find()->where(['contact_id' => $user->contact_id])->all();
                foreach ($networkseliminar as $netaborrar) {
                    $contactnetworktable->delete($netaborrar);
                }

                $username = $user->username;
                $user = $this->Adminusers->delete($user);
                $contactotable->delete($contacto);

                $logs = TableRegistry::get('Logs');
                $log = $logs->newEmptyEntity();
                $log->username = $this->Auth->user('username');
                $log->description = $this->Auth->user('username') . " ha eliminado el usuario " . $nombre;
                $logs->save($log);

                $eliminados = true;
            }


        }

        if ($eliminados) {
            $this->Flash->success(__('Los usuarios han sido eliminados'));
        } else {
            $this->Flash->error(__('No se ha eliminado ningun usuario'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        if ($this->request->is('post')) {

            $usernameInput = mb_strtolower(trim($this->request->getData('username') ?? ''));
            $password = (string) $this->request->getData('password');

            $logs = TableRegistry::get('Logs');
            $log = $logs->newEmptyEntity();

            // Intento como admin
            $admin = $this->Adminusers->find()
                ->where(['LOWER(Adminusers.username) =' => $usernameInput])
                ->first();

            if ($admin && (new DefaultPasswordHasher())->check($password, $admin->password)) {
                $this->Auth->setUser($admin->toArray());

                $log->username = $admin->username;
                $log->description = $admin->username . " ha iniciado sesión (admin)";
                $logs->save($log);

                return $this->redirect($this->Auth->redirectUrl());
            }

            $usersTable = TableRegistry::get('Users');
            $appUser = $usersTable->find()
                ->where(['LOWER(Users.username) =' => $usernameInput])
                ->first();

            if ($appUser && (new DefaultPasswordHasher())->check($password, $appUser->password)) {
                // Guardamos usuario en una sesión propia de FamHapp Web
                $this->request->getSession()->write('FamhappUser', $appUser->toArray());

                $log->username = $appUser->username;
                $log->description = $appUser->username . " ha iniciado sesión en FamHapp Web";
                $logs->save($log);

                return $this->redirect('/famhapp/home');
            }
            $log->username = $this->request->getData('username');
            $log->description = "Inicio de sesión incorrecto";
            $logs->save($log);

            $this->Flash->error(__('Usuario o contraseña incorrecto'));
        }
    }


    public function logout()
    {
        $logs = TableRegistry::get('Logs');
        $log = $logs->newEmptyEntity();
        $log->username = $this->Auth->user('username');
        $log->description = $this->Auth->user('username') . " ha finalizado sesión";
        //$now = Time::now();
        //$log->creado=  $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $logs->save($log);
        return $this->redirect($this->Auth->logout());
    }

    /*
    public function forgotpass()
    {
        if ($this->request->is('post')) {
            $email = trim($this->request->getData('email'));

            if ($this->Adminusers->find()->contain(['Contacts'])->where(['email' => $email])->count() < 1) {
                $this->Flash->error(__('No existe un usuario asociado a ese email.'));
                return;
            }

            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';


            $tokentable = TableRegistry::get('Tokens');
            if ($tokentable->find()->where(['email' => $email])->count() > 0) {
                $existentes = $tokentable->find()->where(['email' => $email])->all();
                foreach ($existentes as $existente) {
                    $tokentable->delete($existente);
                }
            }

            $token = $tokentable->newEmptyEntity();
            $token->url = uniqid();
            $tokenplain = substr(str_shuffle($characters), 0, 6);
            $token->token = (new DefaultPasswordHasher)->hash($tokenplain);
            $now = Time::now();
            $token->created = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $token->email = $email;
            $tokentable->save($token);

            $logs = TableRegistry::get('Logs');
            $log = $logs->newEmptyEntity();
            $log->username = $email;
            $log->description = "Se ha iniciado recuperación de contraseña. IP:" . $_SERVER['REMOTE_ADDR'];
            //$now = Time::now();
            //$log->creado=  $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $logs->save($log);

            $correo = new Email('default');
            $correo->from(["password-noreply@badmin.com" => 'FamHapp - No Reply'])
                ->to($email)
                ->subject('Recuperación de contraseña')
                ->send("Se ha iniciado el proceso de recuperación de contraseña. Si usted no ha iniciado el proceso de recuperación informe al administrador del sitio web \n" .
                    "Para restablecer su contraseña entre a la url " . $_SERVER['SERVER_NAME'] . "/resetpsw/" . $token->url . " he introduzca el siguiente ID: " . $tokenplain . "\n\n" .
                    "Dispone de 10 minutos");

            $this->Flash->success(__('Se ha enviado un correo con instrucciones a ' . $email));
            return $this->redirect(['action' => 'login']);
        }


    }
    */



    public function resetpsw($url)
    {

        if ($this->request->is('post')) {

            if (trim($this->request->getData('pass1')) == '') {
                $this->Flash->error(__('Las contraseña no puede estar vacia'));
                return;
            }

            if (strcmp($this->request->getData('pass1'), $this->request->getData('pass2')) != 0) {
                $this->Flash->error(__('Las contraseñas no coinciden'));
                return;
            }

            $tokentable = TableRegistry::get('Tokens');
            if ($tokentable->find()->where(['url' => $url])->count() < 1) {
                $this->Flash->error(__('No existe ningún proceso de recuperación para esta url'));
                return;
            }



            $eltoken = $tokentable->find()->where(['url' => $url])->first();


            if (!(new DefaultPasswordHasher)->check($this->request->getData('id'), $eltoken->token)) {
                $this->Flash->error(__('ID incorrecto'));
                return;
            }


            $time = new Time($eltoken->created, 'Europe/Madrid');

            if (!$time->wasWithinLast('10 minutes')) {
                $this->Flash->error(__('El tiempo para el proceso de recuperación ha expirado. Comience de nuevo'));
                $tokentable->delete($eltoken);
                return;
            }

            $eluser = $this->Adminusers->find()->contain(['Contacts'])->where(['email' => $eltoken->email])->first();
            $eluser->password = $this->request->getData('pass1');
            $this->Adminusers->save($eluser);

            $tokentable->delete($eltoken);

            $logs = TableRegistry::get('Logs');
            $log = $logs->newEmptyEntity();
            $log->username = $eluser->username;
            $log->description = "Se ha restablecido la contraseña. IP:" . $_SERVER['REMOTE_ADDR'];
            $logs->save($log);
            $this->Flash->success(__('Se ha restablecido la contraseña'));
            return $this->redirect(['action' => 'login']);

        }


    }
}
