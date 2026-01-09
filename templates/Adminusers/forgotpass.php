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
        <div id="login-header" style="height:80px;         
            background:#3d3d3d;     
            display:flex;           
            justify-content:center;    
            align-items:center;"> 
          <img src="/img/nuevo/famhappP.png" alt="FamHapp Panel" style="width:190px;         
              height:auto;">
        </div>
        <div id="login-container">
          <p id="claim">Introduce tu email para recuperar la contraseña</p>
          <div class="row row-sinmargen">
            <form method="post" action="#">
              <fieldset>
                <div class="grupo">
                  <input type="email" name="email" maxlength="255" id="email" class="login" placeholder="Email"
                    autofocus="autofocus">
                </div>
              </fieldset>
              <button type="submit" name="Guardar" value="guardar">Recuperar constraseña</button>
            </form>
            <a id="forgotlink" href="/login">
              <p>Volver al login</p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>