<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\View\CellTrait;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * sliders Controller
 *
 * @property \App\Model\Table\SlidersTable $Sliders
 */
class MultimediaController extends AppController
{

  use CellTrait;

  const IMAGE_TYPES = ['image/jpeg', 'image/gif', 'image/png'];
  const VIDEO_TYPES = ['video/mp4', 'video/ogg', 'video/quicktime'];


  const DOCUMENT_TYPES = [
    'application/zip',
    'application/x-zip-compressed',
    'multipart/x-zip',
    'application/x-rar-compressed',
    'application/octet-stream',
    'application/msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.oasis.opendocument.text',
    'application/vnd.oasis.opendocument.spreadsheet',
    'text/plain',
    'text/csv',
    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/vnd.ms-powerpoint',
    'application/vnd.oasis.opendocument.presentation',
    'application/pdf'
  ];



  public function beforeFilter(\Cake\Event\EventInterface $event)
  {

    parent::beforeFilter($event);
    $menuadmin = $this->cell('Menuadmin', ['multimedia']);
    $headeradmin = $this->cell('Headeradmin', [$this->Auth->user()]);
    $this->set(['menuadmin' => $menuadmin]);
    $this->set(['headeradmin' => $headeradmin]);
    $this->loadComponent('Paginator');
  }


  public function prueba()
  {
    //$misdatos= $this->getimages();
    //  $this->set(['misdatos' => $misdatos]);
  }

  /*
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index()
  {
    $this->paginate = [ // here we have define limit of the record on the page
      'limit' => '10',
      'where' => ['id >' => 0],
      'order' => ['id' => 'DESC']
    ];


    $this->set('multimedia', $this->paginate($this->Multimedia->find('all')->where(['id >' => 0])->order(['id' => 'DESC'])));
  }

  public function superindex()
  {

    $multimedia = $this->Multimedia->find()->where(['id >' => 0])->order(['id' => 'DESC'])->all();

    return $multimedia;
  }




  public function view($id = null)
  {
    if ($id < 1) {
      $this->Flash->error(__('Multimedia del sistema, permiso denegado'));
      return $this->redirect(['action' => 'index']);
    }

    $multimedia = $this->Multimedia->get($id, [
      'contain' => []
    ]);



    $this->set('multimedia', $multimedia);
    $this->set('_serialize', ['multimedia']);
  }

  public function edit($id)
  {
    if ($id < 1) {
      $this->Flash->error(__('Multimedia del sistema, permiso denegado'));
      return $this->redirect(['action' => 'index']);
    }

    $multimedia = $this->Multimedia->get($id, [
      'contain' => []
    ]);



    $this->set('multimedia', $multimedia);
    $this->set('_serialize', ['multimedia']);

    if ($this->request->is('post')) {
      $multimedia->title = $this->request->getData('titulo');
      $multimedia->alt = $this->request->getData('alt');
      $multimedia->description = $this->request->getData('descripcion');

      if ($this->Multimedia->save($multimedia)) {
        $logs = TableRegistry::get('Logs');
        $log = $logs->newEmptyEntity();
        $log->username = $this->Auth->user('username');
        $log->description = $this->Auth->user('username') . " ha editado la imagen " . $multimedia->title;
        $logs->save($log);
        $this->Flash->success(__('Imagen editada.'));
        return $this->redirect(['action' => 'index']);
      }

      $this->Flash->error(__('Error editando imagen'));
    }
  }

  public function uploadmultimedia()
  {
    // Si no es POST o no viene nada, devolvemos error
    if (!$this->request->is('post') || empty($this->request->getUploadedFiles())) {
      throw new BadRequestException(__('Petición inválida.'));
    }

    // Recuperamos el archivo (Dropzone envía por defecto 'file')
    $archivo = $this->request->getUploadedFiles()['file'] ?? null;
    if (!$archivo) {
      throw new BadRequestException(__('No llegó el archivo.'));
    }

    // Validamos tipo MIME (opcional: extiende la lista si necesitas más formatos)
    $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'application/pdf'];
    if (!in_array($archivo->getClientMediaType(), $allowedMime)) {
      // Respondemos un JSON con error
      $this->response = $this->response
        ->withType('application/json')
        ->withStringBody(json_encode(['error' => 'Tipo de archivo no permitido.']));
      return $this->response;
    }

    // Genera un nombre seguro y único
    $extension = pathinfo($archivo->getClientFilename(), PATHINFO_EXTENSION);
    $basename = Text::slug(pathinfo($archivo->getClientFilename(), PATHINFO_FILENAME));
    $nuevoNombre = $basename . '-' . uniqid() . '.' . $extension;

    // Carpeta donde guardar (webroot/uploads/multimedia/)
    $uploadPath = WWW_ROOT . 'uploads' . DS . 'multimedia' . DS;
    if (!is_dir($uploadPath)) {
      mkdir($uploadPath, 0755, true);
    }

    // Movemos el archivo
    $archivo->moveTo($uploadPath . $nuevoNombre);

    // Guardamos en BD (suponiendo que tienes una entidad Multimedia)
    $mult = $this->Multimedia->newEmptyEntity();
    $mult->url = '/uploads/multimedia/' . $nuevoNombre;
    $mult->mytype = $this->_determinarTipo($archivo->getClientMediaType());
    $mult->title = $archivo->getClientFilename();
    $this->Multimedia->save($mult);

    // Respondemos JSON de éxito
    $this->response = $this->response
      ->withType('application/json')
      ->withStringBody(json_encode(['success' => true, 'id' => $mult->id]));
    return $this->response;
  }


  public function getimages()
  {
    $this->autoRender = false; // avoid to render view
    $multimedia = $this->Multimedia->find()->where(['id >' => 0])->where(['mytype' => 'image'])->order(['id' => 'DESC'])->all();

    $mijson = json_encode($multimedia);
    $response = $this->response;
    $response = $response->withType('application/json');
    $response = $response->withStringBody($mijson);
    return $response;


  }

  public function getallres()
  {
    $this->autoRender = false; // avoid to render view
    $multimedia = $this->Multimedia->find()->where(['id >' => 0])->order(['id' => 'DESC'])->all();

    $mijson = json_encode($multimedia);
    $response = $this->response;
    $response = $response->withType('application/json');
    $response = $response->withStringBody($mijson);
    return $response;


  }

  public function getdocs()
  {
    $this->autoRender = false; // avoid to render view
    $multimedia = $this->Multimedia->find()->where(['id >' => 0])->where(['mytype' => 'document'])->order(['id' => 'DESC'])->all();

    $mijson = json_encode($multimedia);
    $response = $this->response;
    $response = $response->withType('application/json');
    $response = $response->withStringBody($mijson);
    return $response;


  }


  public function getmultimedia()
  {
    $todos = $this->Multimedia
      ->find()
      ->select(['id', 'url', 'mytype', 'extension' => 'SUBSTRING_INDEX(url, \'.\', -1)', 'alt' => 'title'])
      ->order(['created' => 'DESC'])
      ->enableHydration(false)
      ->toArray();

    $this->response = $this->response
      ->withType('application/json')
      ->withStringBody(json_encode($todos));
    return $this->response;
  }

  protected function _determinarTipo($mime)
  {
    if (strpos($mime, 'image/') === 0) {
      return 'image';
    }
    if (strpos($mime, 'video/') === 0) {
      return 'video';
    }
    if ($mime === 'application/pdf') {
      return 'document';
    }
    return 'file';
  }
  public function delete($id = null)
  {
    $users = TableRegistry::get('Adminusers');

    $hayusers = $users->find()->where(['multimedia_id' => $id])->all();


    if (!$hayusers->isEmpty()) {
      $this->Flash->error('La imagen no ha podido ser eliminada, hay contenido que la utiliza.');
      return $this->redirect(['action' => 'index']);
    }

    $this->request->allowMethod(['post', 'delete']);
    $image = $this->Multimedia->get($id);

    unlink(WWW_ROOT . str_replace('/multimedia', 'multimedia', $image->url));
    if ($this->Multimedia->delete($image)) {
      $this->Flash->success('La imagen ha sido eliminada');
    } else {
      $this->Flash->error('La imagen no ha podido ser eliminada.');
    }

    return $this->redirect(['action' => 'index']);
  }

  public function cleanAll()
  {
    // $multimedia = $this->Multimedia->find()->where(['id >' => 0])->order(['id' => 'DESC'])->all()->extract('id')->toArray();


    $users = TableRegistry::get('Adminusers');



    $hayusers = $users->find()->all()->extract('multimedia_id')->toArray();


    // $toClean = array_diff($multimedia, $hayteams);
    // $toClean = array_values($toClean);

    $multimedia = $this->Multimedia->find()->where(['id >' => 0])
      ->where(['id NOT IN' => $hayusers])
      ->order(['id' => 'DESC'])
      ->all()
      ->extract('id')
      ->toArray();

    if (sizeOf($multimedia) == 0) {
      $this->Flash->error('No hay multimedia sin utilizar.');
      return $this->redirect(['action' => 'index']);
    } else {
      $eliminados = false;
      foreach ($multimedia as $id) {
        $mult = $this->Multimedia->get($id);
        unlink(WWW_ROOT . str_replace('/multimedia', 'multimedia', $mult->url));
        $this->Multimedia->delete($mult);
        $eliminados = true;
      }
      if ($eliminados) {
        $logs = TableRegistry::get('Logs');
        $log = $logs->newEmptyEntity();
        $log->username = $this->Auth->user('username');
        $log->description = $this->Auth->user('username') . " ha realizado una limpieza de multimedia no usada.";
        $logs->save($log);
        $this->Flash->success(__('Multimedia no usada eliminada.'));
      } else {
        $this->Flash->error(__('No se ha eliminado ninguna multimedia.'));
      }
      return $this->redirect(['action' => 'index']);
    }
  }




}
