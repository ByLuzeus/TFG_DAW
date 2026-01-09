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
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>

<?= $menuadmin ?>
<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties index large-9 medium-8 columns content">
    <div id="panel_header">
      <h3><?= __('Usuarios app') ?></h3>
      <div id="action-buttons">
        <a id="action-add" href="/users/add" class="link-action">
          <span class="hidden-xs">Añadir</span><i class="material-icons visible-xs-block">add</i>
        </a>

        <a id="action-edit" href="#" class="link-action unactive">
          <span class="hidden-xs">Editar</span><i class="material-icons visible-xs-block">edit</i>
        </a>

        <a id="action-del" href="#" class="link-action dellink unactive">
          <span class="hidden-xs">Eliminar</span><i class="material-icons visible-xs-block">delete</i>
        </a>
      </div>
    </div>

    <!-- TABLA -->
    <div class="container-full-tabla">
      <table id="eventos" class="stripe" cellpadding="0" cellspacing="0">
        <thead>
          <tr>
            <th>
              <label class="cbcontainer checkHead">
                <input type="checkbox" id="checkAll">
                <span class="checkmark"></span>
              </label>
            </th>
            <th class="search">Usuario</th>
            <th class="search">Padre/Hijo</th>
            <th class="search">Nombre</th>
            <th class="search">Ciudad</th>
            <th class="search">Email</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $user): ?>
            <tr data-username="<?= h($user->username) ?>" data-role="<?= $user->isfather ? 'padre' : 'hijo' ?>"
              data-father="<?= h($user->father ?: '') ?>">
              <td class="ordercol">
                <label class="cbcontainer">
                  <input type="checkbox" class="checkRow">
                  <span class="checkmark"></span>
                </label>
              </td>
              <td><?= h($user->username) ?></td>
              <td><?= $user->isfather ? 'Padre' : 'Hijo de ' . h($user->father) ?></td>
              <td><?= h($user->name ?: '-') ?>   <?= h($user->lastname ?: '-') ?></td>
              <td><?= h($user->city ?: '-') ?></td>
              <td><?= h($user->email ?: '-') ?></td>
              <td>
                <a href="/users/view/<?= h($user->username) ?>">
                  <span class="hidden-xs">Ver +</span><i class="material-icons visible-xs-block">link</i>
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal --------------------------------------------------------------- -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title" id="modalTitle">Eliminar</h3>
      </div>

      <div class="modal-body">
        <p id="modalMsg"></p>
      </div>

      <div class="modal-footer">
        <?= $this->Form->create(null, ['url' => ['action' => 'delete'], 'id' => 'formDel', 'class' => 'inline']) ?>
        <div id="ids-borrar"></div>
        <button type="button" class="link-action" data-dismiss="modal">Volver</button>
        <button type="submit" class="link-action dellink" id="btnEliminar">Eliminar</button>
        <?= $this->Form->end() ?>
      </div>

    </div>
  </div>
</div>

<!-- Modal aux -->
<div class="modal fade" id="modalMultiple" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Importante</h3>
      </div>
      <div class="modal-body">
        <p>No puedes eliminar varios usuarios al mismo tiempo</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="link-action" data-dismiss="modal">Aceptar</button>
      </div>
    </div>
  </div>
</div>


<!-- SCRIPT -------------------------------------------------------------- -->
<script>
  document.addEventListener('DOMContentLoaded', () => {

    const table = document.getElementById('eventos');
    const checkAll = document.getElementById('checkAll');
    const btnEdit = document.getElementById('action-edit');
    const btnDelete = document.getElementById('action-del');
    const idsBorrar = document.getElementById('ids-borrar');

    const modal = $('#modalEliminar');
    const mTitle = document.getElementById('modalTitle');
    const mMsg = document.getElementById('modalMsg');
    const btnSubmit = document.getElementById('btnEliminar');

    const parentsWithKids = new Set();
    table.querySelectorAll('tbody tr').forEach(tr => {
      const father = tr.dataset.father;
      if (father) parentsWithKids.add(father);
    });

    const selected = () => table.querySelectorAll('.checkRow:checked');
    const exactlyOne = () => selected().length === 1;

    const toggleActions = () => {
      const enable = exactlyOne();
      btnEdit.classList.toggle('unactive', !enable);
      btnDelete.classList.toggle('unactive', !enable);
    };

    checkAll.addEventListener('change', () => {
      table.querySelectorAll('.checkRow').forEach(c => c.checked = checkAll.checked);
      toggleActions();
    });

    table.addEventListener('change', e => {
      if (e.target.matches('.checkRow')) {
        toggleActions();
        const total = table.querySelectorAll('.checkRow').length;
        checkAll.checked = selected().length === total;
      }
    });

    /* ---------- EDITAR ---------- */
    btnEdit.addEventListener('click', e => {
      e.preventDefault();
      if (!exactlyOne()) return;            
      const u = selected()[0].closest('tr').dataset.username;
      location.href = `/users/edit/${encodeURIComponent(u)}`;
    });

    // ---------- ELIMINAR ----------
    btnDelete.addEventListener('click', e => {
      e.preventDefault();
      const seleccionadas = selected().length;

      if (seleccionadas === 0) {
        // no se hace nada XD
        return;
      }

      if (seleccionadas > 1) {
        $('#modalMultiple').modal('show');
        return;
      }

      const row = selected()[0].closest('tr');
      const user = row.dataset.username;
      const role = row.dataset.role;

      idsBorrar.innerHTML = '';
      const hidden = document.createElement('input');
      hidden.type = 'hidden';
      hidden.name = 'usernames[]';
      hidden.value = user;
      idsBorrar.appendChild(hidden);

      if (role === 'padre' && parentsWithKids.has(user)) {
        mTitle.textContent = 'Importante';
        mMsg.textContent = 'No puedes eliminar un padre con hijos asociados';
        btnSubmit.style.display = 'none';
      } else {
        mTitle.textContent = 'Eliminar';
        mMsg.innerHTML = `¿Estás seguro de que desea eliminar al usuario <b>${user}</b>?`;
        btnSubmit.style.display = '';
      }
      modal.modal('show');
    });
    toggleActions();  
  });
</script>