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

$this->layout = 'admin-appdatas';
$cakeDescription = __('FamHapp - Dashboard, Panel de administración');
?>
<div class="metas">
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>

<div id="micontent" class="shown">
  <?= $headeradmin ?>
  <div class="properties index large-9 medium-8 columns content">
    <div id="panel_header">
      <h3><?= __('Catálogo APPs') ?></h3>
      <div id="action-buttons">
        <a id="action-add" href="/appdatas/add" class="link-action">
          <span class="hidden-xs">Añadir</span>
          <i class="material-icons visible-xs-block">add</i>
        </a>
        <a id="action-edit" class="link-action unactive" href="#">
          <span class="hidden-xs">Editar</span>
          <i class="material-icons visible-xs-block">edit</i>
        </a>
        <a id="action-del" data-toggle="modal" data-target="#modalEliminar" class="link-action dellink unactive">
          <span class="hidden-xs">Eliminar</span>
          <i class="material-icons visible-xs-block">delete</i>
        </a>
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
            <th class="search">Paquete</th>
            <th class="search">Categoría</th>
            <th class="search">Dispositivo</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appdatas as $appdata): ?>
          <tr data-tableid="<?= h($appdata->id) ?>">
            <td class="ordercol">
              <label class="cbcontainer">
                <input type="checkbox" name="check" class="checkRow" value="<?= h($appdata->id) ?>">
                <span class="checkmark"></span>
              </label>
            </td>
            <td><?= h($appdata->appname) ?></td>
            <td><?= h($appdata->packagename) ?></td>
            <td><?= h($appdata->appcategory) ?></td>
            <td>
              <?php
                if ((int)$appdata->devicetype === 1) {
                  echo 'iOS';
                } else {
                  echo 'Android';
                }
              ?>
            </td>
            <td>
              <a href="/appdatas/view/<?= h($appdata->id) ?>">
                <span class="hidden-xs">Ver +</span>
                <i class="material-icons visible-xs-block">link</i>
              </a>
            </td>
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
        <p class="modal-mensaje">¿Estás seguro de eliminar las apps seleccionadas?</p>
      </div>
      <div class="modal-footer">
        <?= $this->Form->create(null, ['url' => ['controller' => 'Appdatas', 'action' => 'delete']]) ?>
          <div id="ids-borrar"></div>
          <button type="button" class="link-action" data-dismiss="modal">Volver</button>
          <?= $this->Form->button(__('Eliminar'), ['class' => 'link-action dellink', 'id' => 'enlace-eliminar']) ?>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const selectAllCheckbox = document.querySelector('.checkHead input.checkPrivacy');
    const rowCheckboxes = Array.from(document.querySelectorAll('input.checkRow'));
    const editButton = document.getElementById('action-edit');
    const deleteButton = document.getElementById('action-del');
    const idsBorrar = document.getElementById('ids-borrar');

    function updateActionButtons() {
      const checkedRows = rowCheckboxes.filter(cb => cb.checked);
      const count = checkedRows.length;

      if (count === 1) {
        editButton.classList.remove('unactive');
        const id = checkedRows[0].value;
        editButton.setAttribute('href', `/appdatas/edit/${id}`);
      } else {
        editButton.classList.add('unactive');
        editButton.setAttribute('href', '#');
      }

      if (count > 0) {
        deleteButton.classList.remove('unactive');
      } else {
        deleteButton.classList.add('unactive');
      }
    }

    rowCheckboxes.forEach(cb => {
      cb.addEventListener('change', updateActionButtons);
    });

    if (selectAllCheckbox) {
      selectAllCheckbox.addEventListener('change', () => {
        const checked = selectAllCheckbox.checked;
        rowCheckboxes.forEach(cb => {
          cb.checked = checked;
        });
        updateActionButtons();
      });
    }

    $('#modalEliminar').on('show.bs.modal', () => {
      idsBorrar.innerHTML = '';
      const checkedRows = rowCheckboxes.filter(cb => cb.checked);
      checkedRows.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'ids[]';
        input.value = cb.value;
        idsBorrar.appendChild(input);
      });
    });

    updateActionButtons();
  });
</script>