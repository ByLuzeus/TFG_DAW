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

$this->layout = 'admin-levels';
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
      <h3><?= __('Niveles') ?></h3>
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
            <th class="search">Nombre</th>
            <th class="search">Puntos</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($levels as $level): ?>
            <tr data-tableid="<?= h($level->id) ?>">
              <td class="ordercol">
                <label class="cbcontainer">
                  <input type="checkbox" name="check" class="checkRow">
                  <span class="checkmark"></span>
                </label>
              </td>
              <td><?= h($level->description) ?></td>
              <td><?php echo ($level->pointsprice); ?></td>
              <td><a href="/levels/edit/<?= h($level->id) ?>"><span class="hidden-xs">Editar</span><i
                    class="material-icons visible-xs-block">edit</i></a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <h3 aria-hidden="true">&times;</h3>
        </button>
        <h3 class="modal-title">Eliminar</h3>
      </div>
      <div class="modal-body">
        <p class="modal-mensaje">¿Estás seguro de eliminar los usuarios seleccionados?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="/levels/delete">
          <div id="ids-borrar"></div>
          <button type="button" class="link-action" data-dismiss="modal">Volver</button>
          <button id="enlace-eliminar" type="submit" class="link-action dellink">Eliminar</a>
        </form>
      </div>
    </div>
  </div>
</div>