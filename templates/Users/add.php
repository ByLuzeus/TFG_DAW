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

$this->layout = 'admin-users-edit';
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
    <?= $this->Form->create($user, ['type' => 'file']) ?>

    <!-- CABECERA + ACCIONES -->
    <div id="panel_header">
      <h3><?= __('Añadir usuario') ?></h3>
      <div id="action-buttons">
        <?= $this->Form->button(
          '<span class="hidden-xs">' . __('Guardar') . '</span><i class="material-icons visible-xs-block">save</i>',
          [
            'type' => 'submit',
            'class' => 'link-action addlink',
            'id' => 'action-save',
            'escapeTitle' => false
          ]
        ) ?>
        <?= $this->Html->link(
          '<span class="hidden-xs">' . __('Descartar') . '</span><i class="material-icons visible-xs-block">arrow_back</i>',
          ['action' => 'index'],
          ['class' => 'link-action', 'id' => 'action-del', 'escapeTitle' => false]
        ) ?>
      </div>
    </div>

    <?= $this->Flash->render() ?>

    <div class="container-fluid container-full-blanco container-edit mt-2">
      <p class="mandatory-fields-notice">
        <?= __('Los campos marcados con asterisco (*) son obligatorios.') ?>
      </p>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Nombre de usuario *') ?></p>
            <?= $this->Form->text('username', [
              'maxlength' => 50,
              'required' => true,
              'id' => 'username'
            ]) ?>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Rol *') ?></p>
            <?= $this->Form->select(
              'role',
              ['Padre' => 'Padre', 'Hijo' => 'Hijo'],
              [
                'empty' => __('Seleccione…'),
                'class' => 'selectform',
                'required' => true,
                'id' => 'role'
              ]
            ) ?>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Email *') ?></p>
            <?= $this->Form->email('email', ['required' => true, 'id' => 'email']) ?>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Nivel *') ?></p>
            <?= $this->Form->select('level_id', $levels, [
              'class' => 'selectform',
              'required' => true,
              'id' => 'level-id'
            ]) ?>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Nombre *') ?></p>
            <?= $this->Form->text('name', ['required' => true, 'id' => 'name']) ?>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Apellidos *') ?></p>
            <?= $this->Form->text('lastname', ['required' => true, 'id' => 'lastname']) ?>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Teléfono *') ?></p>
            <?= $this->Form->text('phone', ['required' => true, 'id' => 'phone']) ?>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Fecha de nacimiento *') ?></p>
            <?= $this->Form->date('birthdate', ['required' => true, 'id' => 'birthdate']) ?>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Puntos recompensa *') ?></p>
            <?= $this->Form->number('rewardpoints', [
              'min' => 0,
              'step' => 1,
              'required' => true,
              'id' => 'rewardpoints'
            ]) ?>
          </div>
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo"><?= __('Contraseña *') ?></p>
            <?= $this->Form->password('password', ['required' => true, 'id' => 'password']) ?>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo"><?= __('Padre *') ?></p>
            <?= $this->Form->select('father', $parents, [
              'empty' => __('Seleccione un padre…'),
              'class' => 'selectform',
              'id' => 'father'
            ]) ?>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo"><?= __('Ciudad *') ?></p>
            <?= $this->Form->text('city', ['required' => true, 'id' => 'city']) ?>
          </div>
        </div>
      </div>
    </div>

    <?= $this->Form->end() ?>
  </div>
</div>

<style>
  .disabled-field,
  .selectform.disabled-field {
    background: #e0e0e0 !important;
    border: 1px solid #cccccc;
    color: #777;
    pointer-events: none;
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const role = document.getElementById('role');
    const father = document.getElementById('father');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');

    function toggleFields() {
      const isChild = role.value === 'Hijo';

      // habilita / deshabilita campos
      email.disabled = isChild;
      phone.disabled = isChild;
      father.disabled = !isChild;
      father.required = isChild;

      [email, phone].forEach(el => el.classList.toggle('disabled-field', isChild));
      father.classList.toggle('disabled-field', !isChild);

      if (isChild) {
        email.value = '';
        phone.value = '';
      } else {
        father.selectedIndex = 0;
      }
    }

    role.addEventListener('change', toggleFields);
    toggleFields();
  });
</script>