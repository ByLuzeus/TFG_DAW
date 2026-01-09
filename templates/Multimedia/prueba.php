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

$this->layout = 'admin-articles-edit';
$cakeDescription = __('FamHapp - Dashboard, Panel de adminsitración');
?>
<div class="metas">
  <title>
      <?= $cakeDescription ?>
  </title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>
    <div id="micontent" class="shown">
      <?= $headeradmin ?>
      <div class="properties form large-9 medium-8 columns content">
        <? debug(constant("ID_DEFAULT_USER_IMAGE"))?>
     <form method="post" action="#" enctype="multipart/form-data">

            <div class="row">
              <div class="col-lg-12 col-md-12">
                <p class="dato-titulo">Imagen *</p>
                <input type="file" name="imagen"  id="imagen">
              </div>
               <button class="link-action addlink" id="btn-aceptar" type="submit" name="Guardar" value="guardar" >Guardar</button>
      </div>
    </form>
</div>
