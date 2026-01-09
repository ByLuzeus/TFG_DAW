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

$this->layout       = 'admin-appdatas';
$cakeDescription    = __('FamHapp - Dashboard, Panel de administración');
?>
<div class="metas">
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>

<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties form large-9 medium-8 columns content">
    <form>
      <!-- CABECERA -->
      <div id="panel_header">
        <h3><?= __('App: ') . h($appdata->appname) ?></h3>
        <div id="action-buttons">
          <a class="link-action" href="/appdatas">
            <span class="hidden-xs"><?= __('Volver') ?></span>
            <i class="material-icons visible-xs-block">arrow_back</i>
          </a>
          <a class="link-action" href="/appdatas/edit/<?= h($appdata->id) ?>">
            <span class="hidden-xs"><?= __('Editar') ?></span>
            <i class="material-icons visible-xs-block">edit</i>
          </a>
        </div>
      </div>

      <!-- CONTENIDO -->
      <div class="container-fluid container-full-blanco container-edit">
        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">

          <!-- Paquete -->
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <p class="dato-titulo"><?= __('Paquete') ?></p>
              <p class="dato-data"><?= h($appdata->packagename) ?></p>
            </div>
          </div>

          <!-- Nombre de la APP  -->
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12">
              <p class="dato-titulo"><?= __('Nombre de la APP') ?></p>
              <p class="dato-data"><?= h($appdata->appname) ?></p>
            </div>
          </div>

          <!-- Dispositivo + Categoría  -->
          <div class="row mt-2">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Dispositivo') ?></p>
              <p class="dato-data">
                <?= ((int)$appdata->devicetype === 1) ? 'iOS' : 'Android' ?>
              </p>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Categoría') ?></p>
              <p class="dato-data"><?= h($appdata->appcategory) ?></p>
            </div>
          </div>

          <!-- Fecha  -->
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12">
              <p class="dato-titulo"><?= __('Fecha') ?></p>
              <p class="dato-data"><?= h($appdata->timestamp) ?></p>
            </div>
          </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right"></div>
      </div>

    </form>
  </div>
</div>