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
    <?= $this->Form->create($reward, ['id' => 'frm-reward']) ?>

  
    <div id="panel_header">
      <h3><?= __('Editar Recompensa: ') . h($reward->description) ?></h3>
      <div id="action-buttons">
        <?= $this->Form->button(
              '<span class="hidden-xs">' . __('Guardar') . '</span><i class="material-icons visible-xs-block">save</i>',
              [
                'type'        => 'submit',
                'class'       => 'link-action addlink',
                'id'          => 'action-save',
                'escapeTitle' => false
              ]
        ) ?>
        <?= $this->Html->link(
              '<span class="hidden-xs">' . __('Descartar') . '</span><i class="material-icons visible-xs-block">arrow_back</i>',
              ['action' => 'index'],
              ['class' => 'link-action', 'id' => 'action-del', 'escape' => false]
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
            <p class="dato-titulo"><?= __('Descripción *') ?></p>
            <?= $this->Form->text('description', [
                  'required'  => true,
                  'maxlength' => 200,
                  'id'        => 'description',
            ]) ?>
          </div>
        </div>

        <div class="row mt-2">
  
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Tipo *') ?></p>
            <?= $this->Form->select('type_id', $rewardsTypes, [
                  'empty'    => __('Seleccione…'),
                  'class'    => 'selectform',
                  'required' => true,
                  'id'       => 'type-id',
                  'value'    => $reward->type_id
            ]) ?>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Puntos *') ?></p>
            <?= $this->Form->number('points', [
                  'readonly' => true,
                  'class'    => 'disabled-field',
                  'id'       => 'points',
                  'value'    => $reward->points,
                  'min'      => 0,
            ]) ?>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo"><?= __('Usuario') ?></p>
            <?= $this->Form->text('username', [
                  'id'       => 'username',
                  'class'    => 'disabled-field',
                  'disabled' => true,
                  'value'    => $reward->username
            ]) ?>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
      </div>
    </div>

    <?= $this->Form->end() ?>
  </div>
</div>

<style>
    .disabled-field {
        background: #e0e0e0;
        border: 1px solid #cccccc;
        pointer-events: none;
    }
</style>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('type-id');
    const pointsInput = document.getElementById('points');

  
    const tipoAPuntos = <?= json_encode($typePointsMap, JSON_UNESCAPED_UNICODE) ?>;

    function actualizarPuntos() {
      const tipoId = parseInt(typeSelect.value, 10);
      if (!isNaN(tipoId) && tipoAPuntos.hasOwnProperty(tipoId)) {
        pointsInput.value = tipoAPuntos[tipoId];
      } else {
        pointsInput.value = '';
      }
    }

    // Al cambiar el select de tipo, actualiza puntos
    typeSelect.addEventListener('change', actualizarPuntos);

    // Al cargar, prellena los puntos según el tipo actual
    if (typeSelect.value) {
      actualizarPuntos();
    }
  });
</script>