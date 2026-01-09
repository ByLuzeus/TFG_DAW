<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\View\CellTrait;
use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class LicensesController extends AppController
{
    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {

        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['licenses']);
        $this->set(['menuadmin' => $menuadmin]);
        $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
        $this->set(['headeradmin' => $headeradmin]);
    }

    public function index()
    {

        $licenses = $this->Licenses->find()->all();


        $this->set(compact('licenses'));
        $this->set('_serialize', ['licenses']);
    }

    function generarCaracterAleatorio()
    {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return $caracteres[rand(0, strlen($caracteres) - 1)];
    }

    private function generateKey(): string
    {
        $year = date('y');
        $month = date('m');

        $code = $this->generarCaracterAleatorio() . $this->generarCaracterAleatorio();
        $code .= "-{$year}";

        for ($i = 0; $i < 4; $i++) {
            $code .= $this->generarCaracterAleatorio();
        }

        $code .= "-";

        for ($i = 0; $i < 2; $i++) {
            $code .= $this->generarCaracterAleatorio();
        }

        $code .= $month;
        return $code;
    }

    public function emailSearch()
    {
        $this->request->allowMethod('get');
        $term = trim((string) $this->request->getQuery('email'));

        if (!filter_var($term, FILTER_VALIDATE_EMAIL)) {
            $this->set(['users' => []]);
            $this->viewBuilder()->setOption('serialize', ['users']);
            return;
        }
        $users = $this->Licenses->Users
            ->find()
            ->select(['username', 'name'])
            ->where(['LOWER(email) =' => strtolower($term)])  
            ->all()
            ->map(fn($u) => ['username' => $u->username, 'name' => $u->name])
            ->toList();

        $this->set(compact('users'));
        $this->viewBuilder()->setOption('serialize', ['users']);
    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersList = $this->Licenses->Users
            ->find('list', ['keyField' => 'username', 'valueField' => 'name'])
            ->order(['name' => 'ASC'])
            ->toArray();

        $usersList = ['' => 'Usuario no registrado'] + $usersList;

        if ($this->request->is('post')) {

            $qty = (int) $this->request->getData('licensesnumber');
            $username = trim($this->request->getData('username') ?? '');
            $email = trim($this->request->getData('email') ?? '');

            // validaciones mínimas
            if ($qty < 1 || $qty > 5) {
                $this->Flash->error(__('El número de licencias debe estar entre 1 y 5.'));
                return;
            }
            if ($username === '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->Flash->error(__('Debes indicar un email válido si no seleccionas usuario.'));
                return;
            }

            if ($username !== '') {
                $u = $this->Licenses->Users->find()
                    ->select(['email'])
                    ->where(['username' => $username])
                    ->first();
                if (!$u) {
                    $this->Flash->error(__('El usuario seleccionado no existe.'));
                    return;
                }
                $email = $u->email;
            }

            // creación de licencias 
            for ($i = 1; $i <= $qty; $i++) {

                $entity = $this->Licenses->newEmptyEntity();
                $entity->licensekey = $this->generateKey();
                $entity->username = $username ?: null;
                $entity->email = $email;
                $entity->used = 0;
                $entity->active = 1;
                $entity->free = 1;
                $entity->discount = 0;
                $entity->lastpayment = null;
                $entity->firstpayment = null;
                $entity->sale_id = null;

                if (!$this->Licenses->save($entity)) {
                    $this->Flash->error(__('Error al guardar una de las licencias.'));
                    return;
                }
            }

            $this->Flash->success(__('Licencias creadas.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->set(compact('usersList'));
    }


}
