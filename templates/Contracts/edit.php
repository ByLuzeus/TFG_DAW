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

$this->layout = 'admin-contracts-edit';
$cakeDescription = __('FamHapp - Panel de administración');

$festSelected = $contract->festivities ? explode('-', $contract->festivities) : [];
?>
<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<?= $menuadmin ?>
<div id="micontent" class="shown">
    <?= $headeradmin ?>

    <div class="properties form large-9 medium-8 columns content">

        <?= $this->Form->create($contract) ?>

        <!-- CABECERA -->
        <div id="panel_header">
            <h3><?= __('Editar contrato: {0}', h($contract->username)) ?></h3>

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
                    <!-- Username -->
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="dato-titulo"><?= __('Nombre de usuario') ?></p>
                            <?= $this->Form->text('username', [
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Estado -->
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="dato-titulo"><?= __('Estado *') ?></p>
                            <?= $this->Form->select('state_id', $states, [
                                'class' => 'selectform'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Fechas -->
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="dato-titulo"><?= __('Fecha inicio') ?></p>
                            <?= $this->Form->datetime('startdate', [
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                        <div class="col-lg-6">
                            <p class="dato-titulo"><?= __('Fecha finalización') ?></p>
                            <?= $this->Form->datetime('enddate', [
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Fecha contrato -->
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="dato-titulo"><?= __('Fecha del contrato') ?></p>
                            <?= $this->Form->date('contractdate', [
                                'disabled' => true,
                                'class' => 'disabled-field'
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
                    <!-- Finalizado o Activo -->
                    <div class="row">
                        <div class="col-lg-6">
                            <p class="dato-titulo"><?= __('Finalizado') ?></p>
                            <?= $this->Form->select('ended', ['1' => 'Sí', '0' => 'No'], [
                                'class' => 'selectform'
                            ]) ?>
                        </div>
                        <div class="col-lg-6">
                            <p class="dato-titulo"><?= __('Activo') ?></p>
                            <?= $this->Form->select('active', ['1' => 'Sí', '0' => 'No'], [
                                'class' => 'selectform'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Incumplimientos -->
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="dato-titulo"><?= __('Incumplimientos') ?></p>
                            <?= $this->Form->number('breaches', ['min' => 0, 'step' => 1]) ?>
                        </div>
                    </div>

                    <?php
                    $pares = [
                        ['1' => 'Lunes', '2' => 'Martes'],
                        ['3' => 'Miércoles', '4' => 'Jueves'],
                        ['5' => 'Viernes', '6' => 'Sábado'],
                    ];
                    ?>

                    <?php foreach ($pares as $pair): ?>
                        <div class="row">
                            <?php foreach ($pair as $num => $nombre): ?>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <p class="dato-titulo"><?= __('Festivo {0}', $nombre) ?></p>
                                        <?= $this->Form->select(
                                            "festivity_$num",
                                            ['1' => 'Sí', '0' => 'No'],
                                            [
                                                'class' => 'selectform',
                                                'value' => in_array($num, $festSelected) ? '1' : '0'
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>

                    <!-- Domingo solo -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <p class="dato-titulo"><?= __('Festivo Domingo') ?></p>
                                <?= $this->Form->select(
                                    'festivity_7',
                                    ['1' => 'Sí', '0' => 'No'],
                                    [
                                        'class' => 'selectform',
                                        'value' => in_array('7', $festSelected) ? '1' : '0'
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <small><?= __('Marca “Sí” en los días que no contarán como incumplimiento.') ?></small>
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