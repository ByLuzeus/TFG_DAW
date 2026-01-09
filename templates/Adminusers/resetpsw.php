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

$this->layout = 'admin';
$cakeDescription = __('FamHapp - Dashboard, Panel de adminsitración');
?>
<div class="metas">
  <title>
      <?= $cakeDescription ?>
  </title>
  <?= $this->Html->meta('icon') ?>
</div>
<div id="fondo-login" class="container-fluid container-full">
  <div class="col-full-center col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
    <div class="centered-ver">
      <div class="users-form">
        <div id="login-header">
          <img id="logo-cabecera" src="/img/nuevo/B_Admin.svg">
        </div>
        <div id="login-container">
          <p id="claim">Introduce los datos para restablecer la contraseña</p>
      <div class="row row-sinmargen">
      <form method="post" action="#" >
          <fieldset>
            <div class="grupo">
              <input type="text" name="id" maxlength="20" id="id" class="login" placeholder="ID" >
            </div>
            <div class="grupo">
              <input type="password" name="pass1" maxlength="20" id="pass1" class="login" placeholder="Nueva contraseña" >
            </div>
            <div class="grupo">
              <input type="password" name="pass2" maxlength="20" id="pass2" class="login" placeholder="Repita la nueva contraseña" >
            </div>
          </fieldset>
      <button type="submit" name="Guardar" value="guardar" >Cambiar constraseña</button>
      </form>
    </div>
  </div>
      </div>
    </div>
  </div>
</div>
