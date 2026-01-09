<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

$this->layout = 'admin-users';
$cakeDescription = __('FamHapp - Dashboard, Panel de adminsitración');
?>
<div class="metas">
  <title>
      <?= $cakeDescription ?>
  </title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>
    <div id="micontent" class="shown">
      <?= $headeradmin ?>
      <div class="properties form large-9 medium-8 columns content">
     <form method="post" action="#" enctype="multipart/form-data">
       <div id="panel_header">
         <h3>Usuario: <?= $user->username ?></h3>
         <div id="action-buttons">
           <a class="link-action" href="/adminusers"><span class="hidden-xs">Volver</span><i class="material-icons visible-xs-block">arrow_back</i></a>
           <a class="link-action" href="/adminusers/edit/<?= $user->id ?>"><span class="hidden-xs">Editar</span><i class="material-icons visible-xs-block">edit</i></a>
         </div>
       </div>
      <div class="container-fluid container-full-blanco container-edit">
        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Nombre de usuario</p>
              <p class="dato-data"><?= $user->username ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Rol</p>
              <p class="dato-data"><?= $user->role ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Email</p>
              <p class="dato-data"><?= $user->contact->email ?></p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Nombre</p>
              <p class="dato-data"><?= $user->name ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Apellidos</p>
              <p class="dato-data"><?= $user->lastname ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Dirección</p>
              <p class="dato-data"><?= $user->contact->address ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Ciudad</p>
              <p class="dato-data"><?= $user->contact->city ?></p>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Provincia</p>
              <p class="dato-data"><?= $user->contact->state ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">País</p>
              <p class="dato-data"><?= $user->contact->country ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Código Postal</p>
              <p class="dato-data"><?= $user->contact->cp ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Telefono</p>
              <p class="dato-data"><?= $user->contact->tlfn ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Telefono 2</p>
              <p class="dato-data"><?= $user->contact->tlfn2 ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Fax</p>
              <p class="dato-data"><?= $user->contact->fax ?></p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <img class="editProfile" src="<?= $user->multimedia->url ?>">
            </div>
          </div>
        </div>
      </div>
    </form>
</div>
</div>
