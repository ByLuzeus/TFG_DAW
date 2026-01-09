<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc.
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;

$this->layout = 'famhapp';

$cakeDescription = __('Inicio de sesión');
?>
<div class="metas">
    <title><?= $cakeDescription ?></title>
    <?= $this->Html->meta('icon') ?>
</div>

<div class="fh-login-page">
    <div class="fh-login-card">

        <div class="fh-login-logo">
            <?= $this->Html->image('nuevo/famhapp.png', [
                'alt' => 'FamHapp',
                'class' => 'fh-logo'
            ]) ?>
        </div>

        <div class="fh-login-title">
            <h1><?= __('Iniciar sesión') ?></h1>
            <p><?= __('Accede al panel de administración o a la app de FamHapp.') ?></p>
        </div>

        <?= $this->Flash->render('auth') ?>

        <?= $this->Form->create(null, ['class' => 'fh-login-form']) ?>

        <div class="fh-input-group">
            <span class="fh-input-icon">
                <i class="fas fa-user"></i>
            </span>
            <?= $this->Form->text('username', [
                'label' => false,
                'class' => 'fh-input',
                'placeholder' => __('Usuario'),
                'autocomplete' => 'username',
                'autofocus' => true,
                'required' => true
            ]) ?>
        </div>

        <div class="fh-input-group">
            <span class="fh-input-icon">
                <i class="fas fa-lock"></i>
            </span>
            <?= $this->Form->password('password', [
                'label' => false,
                'class' => 'fh-input',
                'placeholder' => __('Contraseña'),
                'autocomplete' => 'current-password',
                'required' => true
            ]) ?>
        </div>

        <div class="fh-actions-row">
            <?= $this->Form->button(__('Iniciar sesión'), [
                'class' => 'fh-btn fh-btn-primary',
                'type' => 'submit'
            ]) ?>

            <div class="fh-register-text">
                <span><?= __('¿No tienes una cuenta como tutor?') ?></span>
                <a href="<?= $this->Url->build(['controller' => 'Famhapp', 'action' => 'registry']) ?>"
                    class="fh-register-link">
                    <?= __('¡Regístrate!') ?>
                </a>
            </div>
        </div>

        <div class="fh-login-help">
            <p><?= __('¿Te has olvidado tu contraseña?') ?></p>
            <a class="fh-link-underline" href="#" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
                <?= __('Restablece tu contraseña') ?>
            </a>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>

<!-- modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalTitle">
                    <?= __('Restablecer contraseña') ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <p><?= __('Por hacer') ?></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <?= __('Aceptar') ?>
                </button>
            </div>

        </div>
    </div>
</div>