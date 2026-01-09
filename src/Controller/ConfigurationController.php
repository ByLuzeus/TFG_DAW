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
class ConfigurationController extends AppController
{
    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
        $this->set('headeradmin', $headeradmin);
    }

    public function contacto()
    {
        $menuadmin = $this->cell('Menuadmin', ['conf-contact']);
        $this->set('menuadmin', $menuadmin);

        $Contacts = $this->fetchTable('Contacts');
        $contacto = $Contacts->get(constant('ID_WEB_CONTACT'), ['contain' => ['Networks']]);

        $Networks = $this->fetchTable('Networks');
        $networksset = $Networks->find()->order(['name' => 'ASC'])->all();
        $this->set('networksset', $networksset);

        if ($this->request->is('post')) {
            $contacto = $Contacts->patchEntity($contacto, $this->request->getData());

            if ($Contacts->save($contacto)) {
                $Contacts->ContactsNetworks->deleteAll(['contact_id' => $contacto->id]);

                $ids  = $this->request->getData('networks_ids')  ?? [];
                $urls = $this->request->getData('networks_urls') ?? [];

                foreach ($ids as $k => $nid) {
                    $entity = $Contacts->ContactsNetworks->newEntity([
                        'contact_id' => $contacto->id,
                        'network_id' => $nid,
                        'url'        => $urls[$k] ?? ''
                    ]);
                    $Contacts->ContactsNetworks->save($entity);
                }

                $logs = $this->fetchTable('Logs');
                $log = $logs->newEmptyEntity();
                $log->username = $this->Auth->user('username');
                $log->description = $this->Auth->user('username') . " ha editado los datos de contacto de la web";
                $logs->save($log);

                $this->Flash->success(__('Datos de contacto guardados correctamente.'));
                return $this->redirect($this->request->getRequestTarget());
            }

            $this->Flash->error(__('No se pudieron guardar los datos de contacto.'));
        }

        $this->set('contacto', $contacto);
    }

    public function legal()
    {
        $menuadmin = $this->cell('Menuadmin', ['conf-legal']);
        $this->set('menuadmin', $menuadmin);

        $Legals = $this->fetchTable('Legals');
        $aviso = $Legals->get(constant('ID_LEGAL_AVISO'));
        $privacidad = $Legals->get(constant('ID_LEGAL_PRIVACIDAD'));
        $cookies = $Legals->get(constant('ID_LEGAL_COOKIES'));
        $this->set(compact('aviso', 'privacidad', 'cookies'));

        if ($this->request->is('post')) {
            $aviso->description = $this->request->getData('aviso');
            $privacidad->description = $this->request->getData('privacidad');
            $cookies->description = $this->request->getData('cookies');

            $Legals->save($aviso);
            $Legals->save($privacidad);
            $Legals->save($cookies);

            $logs = $this->fetchTable('Logs');
            $log = $logs->newEmptyEntity();
            $log->username = $this->Auth->user('username');
            $log->description = $this->Auth->user('username') . " ha editado los textos legales";
            $logs->save($log);

            $this->Flash->success(__('Textos legales editados'));
            return $this->redirect($this->request->getRequestTarget());
        }
    }

    public function manual()
    {
        $menuadmin = $this->cell('Menuadmin', ['conf-uso']);
        $this->set('menuadmin', $menuadmin);
    }

    public function license()
    {
        if ($this->request->is('post')) {
            $check = $this->request->getData('leido');
            if ($check === 'on') {
                $users = TableRegistry::getTableLocator()->get('Users');
                $myuser = $users->find()->where(['username' => $this->Auth->user('username')])->first();
                $myuser->checkLicense = 1;
                $users->save($myuser);
                return $this->redirect($this->Auth->logout());
            }
            return $this->redirect('/licencia');
        }
    }
}