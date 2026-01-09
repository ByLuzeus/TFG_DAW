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

$this->layout = 'admin-users';
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
          <h3><?= __('Solicitudes de eliminación de datos') ?></h3>
          <div id="action-buttons">
          </div>
        </div>
          <div class="container-full-tabla">
          <table id="eventos" class="stripe" cellpadding="0" cellspacing="0">
              <thead>
                  <tr>
                      <th>
                        <label class="cbcontainer checkHead">
                        <input type="checkbox" name="check" class="checkPrivacy">
                        <span class="checkmark"></span>
                        </label>
                      </th>
                      <th class="search">Created</th>
                      <th class="search">Usuario</th>
                      <th class="search">Padre/Hijo</th>
                      <th class="search">Observaciones</th>
                      <th class="search">Mantener uso anónimo</th>
                      <th></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($removes as $remove): ?>
                  <tr data-tableid="<?= h($remove->id) ?>">
                      <td class="ordercol">
                        <label class="cbcontainer">
                        <input type="checkbox" name="check" class="checkRow">
                        <span class="checkmark"></span>
                        </label>
                      </td>
                      <td><?php echo($remove->created); ?></td>
                      <td><a href="/users/view/<?= h($remove->user->username) ?>"><?= h($remove->user->username) ?></a></td>
                      <td>
                        <?php if($remove->user->isfather == 1) {
                          echo('Padre');
                        } else {
                          echo('Hijo - '.$remove->user->father);
                        } ?>
                      </td>
                      <td><?php echo($remove->observations ?: '-'); ?></td>
                      <td><?php echo ($remove->keepanonymous ? 'SI' : 'NO'); ?></td>
                      <td><a href="/removes/view/<?= h($remove->id) ?>"><span class="hidden-xs">Ver +</span><i class="material-icons visible-xs-block">link</i></a></td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>
      </div>
    </div>
