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

$this->layout = 'admin-rewards';
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
    <?= $this->Form->create($commitment, ['id' => 'frm-commitment']) ?>

    <div id="panel_header">
      <h3>
        <?= __('Editar Compromiso: ') . h($commitment->description) ?>
      </h3>
      <div id="action-buttons">
        <?= $this->Form->button(
              '<span class="hidden-xs">' . __('Guardar') . '</span>' .
              '<i class="material-icons visible-xs-block">save</i>',
              ['class' => 'link-action addlink', 'escapeTitle' => false]
        ) ?>
        <?= $this->Html->link(
              '<span class="hidden-xs">' . __('Descartar') . '</span>' .
              '<i class="material-icons visible-xs-block">arrow_back</i>',
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
            <?php
              echo $this->Form->control('type_dummy', [
                'type'      => 'text',
                'label'     => false,
                'disabled'  => true,
                'value'     => h($commitment->commitmenttype->description),
                'class'     => 'disabled-field',
                'templates' => ['inputContainer' => '{{content}}'],
      
              ]);
            ?>
          </div>
        </div>


        <div class="row mt-2">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo"><?= __('Descripción *') ?></p>
            <?= $this->Form->text('description', [
                  'required'  => true,
                  'maxlength' => 200,
                  'id'        => 'description',
            ]) ?>
          </div>
        </div>
      </div>


      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right"></div>
    </div>

    <?= $this->Form->end() ?>
  </div>
</div>

<style>
  .disabled-field {
    background: #e0e0e0 !important;
    border: 1px solid #cccccc !important;
    pointer-events: none;
    color: #595959; 
  }
</style>