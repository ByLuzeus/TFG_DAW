<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\View\CellTrait;

/**
 * Appdatas Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppdatasController extends AppController
{

    use CellTrait;

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $menuadmin = $this->cell('Menuadmin', ['appdatas']);
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

        $appdatas = $this->Appdatas->find()->all();

        $this->set(compact('appdatas'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($packagename = null)
    {
        $appdata = $this->Appdatas->get($packagename);

        $this->set(compact('appdata'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        // listado de categorías 
        $catMap = $this->Appdatas->find()
            ->select(['es' => 'appcategory', 'en' => 'appcategory_en'])
            ->distinct(['appcategory', 'appcategory_en'])
            ->order(['appcategory' => 'ASC'])
            ->enableHydration(false)
            ->combine('es', 'en')
            ->toArray();

        $appdata = $this->Appdatas->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // versión en inglés de la categoría
            $data['appcategory'] = $data['appcategory_es'] ?? null;
            $data['appcategory_en'] = $catMap[$data['appcategory']] ?? null;
            unset($data['appcategory_es']);

            // valores por defecto
            $data += [
                'appicon' => null,
                'timestamp' => date('Y-m-d'),
            ];
            $appdata = $this->Appdatas->patchEntity($appdata, $data);

            if ($this->Appdatas->save($appdata)) {
                $this->Flash->success(__('La APP se ha guardado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo guardar la APP. Revisa los campos obligatorios.'));
        }

        $this->set(compact('appdata', 'catMap'));
    }

    public function edit(int $id)
    {
        $appdata = $this->Appdatas->get($id);

        $catMap = $this->Appdatas->find()
            ->select(['es' => 'appcategory', 'en' => 'appcategory_en'])
            ->distinct(['appcategory', 'appcategory_en'])
            ->order(['appcategory' => 'ASC'])
            ->enableHydration(false)
            ->combine('es', 'en')
            ->toArray();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $data['appcategory'] = $data['appcategory_es'];
            $data['appcategory_en'] = $catMap[$data['appcategory_es']] ?? null;
            unset($data['appcategory_es']);

            $appdata = $this->Appdatas->patchEntity($appdata, $data);
            if ($this->Appdatas->save($appdata)) {
                $this->Flash->success(__('La APP se ha actualizado correctamente.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('No se pudo actualizar la APP.'));
        }

        $this->set(compact('appdata', 'catMap'));
    }

    public function delete()
    {
        $this->request->allowMethod(['post', 'delete']);
        $ids = $this->request->getData('ids') ?? [];
        if (empty($ids)) {
            $this->Flash->error(__('No se seleccionó ninguna APP para eliminar.'));
            return $this->redirect(['action' => 'index']);
        }

        $errors = 0;
        foreach ($ids as $id) {
            try {
                $appdata = $this->Appdatas->get($id);
                if (!$this->Appdatas->delete($appdata)) {
                    $errors++;
                }
            } catch (RecordNotFoundException $e) {
                $errors++;
            }
        }

        if ($errors === 0) {
            $this->Flash->success(__('Las APPs seleccionadas se han eliminado correctamente.'));
        } elseif ($errors === count($ids)) {
            $this->Flash->error(__('No se pudo eliminar ninguna APP. Revise los registros seleccionados.'));
        } else {
            $this->Flash->error(__('Algunas APPs no se pudieron eliminar.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
