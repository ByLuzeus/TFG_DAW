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

$this->layout = 'admin-levels'; 
$cakeDescription = __('FamHapp - Dashboard, Panel de administración'); ?>

<div class="metas">
  <title><?= h($cakeDescription) ?></title>
  <?= $this->Html->meta('icon') ?>
</div>

<?= $menuadmin ?>

<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties form large-9 medium-8 columns content">
    <?= $this->Form->create($rewtype, ['id' => 'frm-rewtype']) ?>

      <div id="panel_header">
        <h3>
          <?= __('Editar tipo de recompensa: ') . h($rewtype->description) ?>
        </h3>
        <div id="action-buttons">
          <?= $this->Form->button(
                '<span class="hidden-xs">' . __('Guardar') . '</span>'
              . '<i class="material-icons visible-xs-block">save</i>',
                ['class' => 'link-action addlink', 'escapeTitle' => false]
          ) ?>
          <?= $this->Html->link(
                '<span class="hidden-xs">' . __('Descartar') . '</span>'
              . '<i class="material-icons visible-xs-block">arrow_back</i>',
                ['action' => 'index'],
                ['class' => 'link-action', 'escape' => false]
          ) ?>
        </div>
      </div>

      <div class="container-fluid container-full-blanco container-edit">
        <p class="mandatory-fields-notice">
          <?= __('Los campos marcados con asterisco (*) son obligatorios.') ?>
        </p>


        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">

   
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <p class="dato-titulo"><?= __('Tipo *') ?></p>
              <?= $this->Form->text('description', [
                    'required'  => true,
                    'maxlength' => 50,
                    'id'        => 'description'
              ]) ?>
            </div>
          </div>

   
          <div class="row mt-2">
            <div class="col-lg-12 col-md-12">
              <p class="dato-titulo"><?= __('Puntos *') ?></p>
              <?= $this->Form->number('points', [
                    'required'  => true,
                    'min'       => 0,
                    'id'        => 'points'
              ]) ?>
            </div>
          </div>

        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right"></div>
      </div>

    <?= $this->Form->end() ?>
  </div>
</div>