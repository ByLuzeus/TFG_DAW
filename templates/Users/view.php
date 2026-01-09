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
          <a class="link-action" href="/users">
            <span class="hidden-xs">Volver</span><i class="material-icons visible-xs-block">arrow_back</i>
          </a>
          <a class="link-action" href="/users/edit/<?= rawurlencode($user->username) ?>">
            <span class="hidden-xs">Editar</span><i class="material-icons visible-xs-block">edit</i>
          </a>
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
              <?php if($user->isfather == 1) { ?>
                <p class="dato-data">PADRE</p>
              <?php } else { ?>
                <p class="dato-data">HIJO</p>
              <?php } ?>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Nombre</p>
              <p class="dato-data"><?= $user->name ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Apellidos</p>
              <p class="dato-data"><?= $user->lastname ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Fecha nacimiento</p>
              <p class="dato-data"><?= $user->birthdate ?></p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo">Localidad</p>
              <p class="dato-data"><?= $user->city ?></p>
            </div>
            <?php if($user->isfather == 0) { ?>
                <div class="col-lg-6 col-md-12">
                    <p class="dato-titulo">Padre</p>
                    <p class="dato-data"><a href="/users/view/<?= $user->father ?>" target="_blank"><?= $user->father ?></a></p>
                </div>
              <?php } ?>
          </div>
          <?php if($user->isfather == 1) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <a id="colENG" class="link-action" data-toggle="collapse" href="#collapseContact" role="button" aria-expanded="false" aria-controls="collapseContact">Datos de contacto</a>
                </div>
            </div>
            <div class="row collapse" id="collapseContact" style="margin-top:60px">
                <div class="col-lg-6 col-md-12">
                <p class="dato-titulo">Email</p>
                <div class="dato-dato"><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></div>
                </div>
                <div class="col-lg-6 col-md-12">
                <p class="dato-titulo">Teléfono</p>
                <div class="dato-dato"><a href="tel:<?= $user->phone ?>"><?= $user->phone ?></a></div>
                </div>
            </div>
          <?php } ?>
          <?php if($user->isfather == 0) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <a id="colENG" class="link-action" data-toggle="collapse" href="#collapsePoints" role="button" aria-expanded="false" aria-controls="collapsePoints">Puntos y nivel</a>
                </div>
            </div>
            <div class="row collapse" id="collapsePoints" style="margin-top:60px">
                <div class="col-lg-6 col-md-12">
                <p class="dato-titulo">Puntos totales</p>
                <div class="dato-dato"><?= $user->totalpoints ?></div>
                </div>
                <div class="col-lg-6 col-md-12">
                <p class="dato-titulo">Puntos recompensa</p>
                <div class="dato-dato"><?= $user->rewardpoints ?></div>
                </div>
                <div class="col-lg-12 col-md-12">
                <p class="dato-titulo">Nivel</p>
                <div class="dato-dato"><?= $user->level->id ?> - <?= $user->level->description ?></div>
                </div>
            </div>
          <?php } ?>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">

        </div>
      </div>
    </form>
</div>
</div>
