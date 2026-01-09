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
$usernameTitle = h($user->username);
$isChild = !empty($user->father);
$roleLabel = $isChild ? __('Hijo') : __('Padre');
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

        <div id="panel_header">
            <h3><?= __('Editar usuario: {0}', $usernameTitle) ?></h3>
            <div id="action-buttons">
                <?= $this->Form->button(
                    '<span class="hidden-xs">' . __('Guardar') . '</span>'
                    . '<i class="material-icons visible-xs-block">save</i>',
                    [
                        'type' => 'submit',
                        'class' => 'link-action addlink',
                        'id' => 'action-save',
                        'escapeTitle' => false
                    ]
                ) ?>

                <?= $this->Html->link(
                    '<span class="hidden-xs">' . __('Volver') . '</span>'
                    . '<i class="material-icons visible-xs-block">arrow_back</i>',
                    ['action' => 'index'],
                    [
                        'class' => 'link-action',
                        'id' => 'action-del',
                        'escape' => false
                    ]
                ) ?>
            </div>
        </div>

        <?= $this->Flash->render() ?>

        <div class="container-fluid container-full-blanco container-edit">
            <p class="mandatory-fields-notice">
                <?= __('Los campos marcados con asterisco (*) son obligatorios.') ?>
            </p>

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Nombre de usuario') ?></p>
                            <?= $this->Form->text('username', [
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Rol') ?></p>
                            <?= $this->Form->text('role_label', [
                                'value' => $roleLabel,
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Email *') ?></p>
                            <?= $this->Form->email('email', [
                                'disabled' => $isChild,
                                'class' => $isChild ? 'disabled-field' : null
                            ]) ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Nivel *') ?></p>
                            <?= $this->Form->select('level_id', $levels, [
                                'class' => 'selectform'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Nombre *') ?></p>
                            <?= $this->Form->text('name') ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Apellidos *') ?></p>
                            <?= $this->Form->text('lastname') ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Teléfono') ?></p>
                            <?= $this->Form->text('phone', [
                                'id' => 'phone',
                                'disabled' => $isChild,
                                'class' => $isChild ? 'disabled-field' : null
                            ]) ?>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Fecha de nacimiento *') ?></p>
                            <?= $this->Form->date('birthdate') ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
                    <div class="row mb-4">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo"><?= __('Puntos recompensa *') ?></p>
                            <?= $this->Form->number('rewardpoints', [
                                'min' => 0,
                                'step' => 1
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12 col-md-12">
                            <p class="dato-titulo">
                                <?= __('Contraseña *') ?>
                                <small>(<?= __('Déjalo en blanco si no quieres cambiarla') ?>)</small>
                            </p>
                            <?= $this->Form->password('password', [
                                'value' => '',
                                'autocomplete' => 'new-password',
                                'placeholder' => '••••••••••',
                                'required' => false,
                                'style' => 'width: 100%;'
                            ]) ?>
                            <?= $this->Form->hidden('password_hash', ['value' => $user->password]) ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12 col-md-12">
                            <p class="dato-titulo"><?= __('Padre') ?></p>
                            <?= $this->Form->text('father', [
                                'value' => $user->father,
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-lg-12 col-md-12">
                            <p class="dato-titulo"><?= __('Ciudad *') ?></p>
                            <?= $this->Form->text('city') ?>
                        </div>
                    </div>
                </div>
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