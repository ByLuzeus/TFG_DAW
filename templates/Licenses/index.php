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

$this->layout = 'admin-licenses';
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
      <div class="properties index large-9 medium-8 columns content">
        <div id="panel_header">
          <h3><?= __('Licencias') ?></h3>
          <div id="action-buttons">
            <a id="action-add" href="/licenses/add" class="link-action"><span class="hidden-xs">Añadir</span><i class="material-icons visible-xs-block">add</i></a>
          </div>
        </div>
          <div class="container-full-tabla">
          <table id="eventos" class="stripe" cellpadding="0" cellspacing="0">
              <thead>
                  <tr>
                      <th class="search">Email asociado</th>
                      <th class="search">Codigo</th>
                      <th class="search">¿Usado?</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($licenses as $license): ?>
                  <tr>
                        <td><?php echo($license->email ?: '-'); ?></td>
                      <td><?= $license->licensekey?></td>
                      <td>
                      <?php if($license->used == 1) {
                          echo('Si');
                        } else {
                          echo('No');
                        } ?>
                      </td>

                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>

      </div>
    </div>
