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

$this->layout = 'admin-appdatas-edit';
$cakeDescription = __('FamHapp - Dashboard, Panel de administración');
?>
<div class="metas">
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>

<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties form large-9 medium-8 columns content">
    <?= $this->Form->create($appdata,['id'=>'frm-app','type'=>'file']) ?>

    <div id="panel_header">
      <h3><?= __('Añadir APP') ?></h3>
      <div id="action-buttons">
        <button id="action-save" class="link-action addlink" type="submit" name="Guardar" value="guardar">
          <span class="hidden-xs">Guardar</span><i class="material-icons visible-xs-block">save</i>
        </button>
        <a id="action-del" class="link-action" href="/appdatas">
          <span class="hidden-xs">Descartar</span><i class="material-icons visible-xs-block">arrow_back</i>
        </a>
      </div>
    </div>

    <div class="container-fluid container-full-blanco container-edit">
      <p class="mandatory-fields-notice">
        <?= __('Los campos marcados con asterisco (*) son obligatorios.') ?>
      </p>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo">Nombre de la APP *</p>
            <input type="text" name="appname" maxlength="255" id="appname" required>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo">Nombre del paquete *</p>
            <input type="text" name="packagename" maxlength="255" id="packagename" required>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo">Dispositivo *</p>
            <select class="selectform" name="devicetype" id="devicetype" required>
              <option value="0"><?= __('Android') ?></option>
              <option value="1"><?= __('iOS') ?></option>
            </select>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo">Categoría *</p>
            <select class="selectform" name="appcategory_es" id="appcategory-es" required>
              <?php foreach (array_keys($catMap) as $key): ?>
                <option value="<?= $key ?>"><?= h($key) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right"></div>
    </div>

    <?= $this->Form->end() ?>
  </div>
</div>