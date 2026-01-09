
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

$this->layout = 'admin-contracts';
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
    <!-- CABECERA + BOTONES -->
    <div id="panel_header">
      <h3><?= __('Contratos') ?></h3>
      <div id="action-buttons">
        <a id="action-edit" href="#" class="link-action unactive">
          <span class="hidden-xs"><?= __('Editar') ?></span>
          <i class="material-icons visible-xs-block">edit</i>
        </a>
        <a id="action-del" href="#" class="link-action dellink unactive">
          <span class="hidden-xs"><?= __('Eliminar') ?></span>
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
                <input type="checkbox" id="checkAll"><span class="checkmark"></span>
              </label>
            </th>
            <th class="search"><?= __('Usuario') ?></th>
            <th class="search"><?= __('Fecha finalización') ?></th>
            <th class="search"><?= __('Última actualización') ?></th>
            <th class="search"><?= __('Incumplimientos') ?></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($contracts as $contract): ?>
            <tr data-tableid="<?= h($contract->id) ?>">
              <td class="ordercol">
                <label class="cbcontainer">
                  <input type="checkbox" class="checkRow"><span class="checkmark"></span>
                </label>
              </td>
              <td><?= h($contract->username) ?></td>
              <td>
                <?= $contract->enddate
                      ? $contract->enddate->i18nFormat('dd/MM/yyyy')
                      : '-' ?>
              </td>
              <td>
                <?= $contract->lastupdate
                      ? $contract->lastupdate->i18nFormat('dd/MM/yyyy')
                      : '-' ?>
              </td>
              <td><?= h($contract->breaches ?? '-') ?></td>
              <td>
                <a href="<?= $this->Url->build(['action' => 'view', $contract->id]) ?>">
                  <span class="hidden-xs"><?= __('Ver +') ?></span>
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

<div class="modal fade" id="modalEliminar" tabindex="-1">
  <div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h3 class="modal-title" id="modalTitle"><?= __('Importante') ?></h3>
    </div>
    <div class="modal-body"><p id="modalMsg"></p></div>
    <div class="modal-footer">
      <?= $this->Form->create(null, [
            'url' => ['action' => 'delete'],
            'id'  => 'formDel',
            'type'=> 'post',
      ]) ?>
        <div id="ids-borrar"></div>
        <button type="button" class="link-action" data-dismiss="modal"><?= __('Volver') ?></button>
        <button type="submit" class="link-action dellink"><?= __('Eliminar') ?></button>
      <?= $this->Form->end() ?>
    </div>
  </div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const table       = document.getElementById('eventos');
  const checkAll    = document.getElementById('checkAll');
  const btnEdit     = document.getElementById('action-edit');
  const btnDelete   = document.getElementById('action-del');
  const idsBorrar   = document.getElementById('ids-borrar');
  const modal       = $('#modalEliminar');
  const mTitle      = document.getElementById('modalTitle');
  const mMsg        = document.getElementById('modalMsg');

  const selected    = () => Array.from(table.querySelectorAll('.checkRow:checked'));
  const selCount    = () => selected().length;

  function toggleButtons() {
    const n = selCount();
    btnEdit.classList.toggle('unactive', n !== 1);
    btnDelete.classList.toggle('unactive', n < 1);
  }


  checkAll.addEventListener('change', () => {
    table.querySelectorAll('.checkRow').forEach(c => c.checked = checkAll.checked);
    toggleButtons();
  });

  table.addEventListener('change', e => {
    if (!e.target.matches('.checkRow')) return;
    const all = table.querySelectorAll('.checkRow').length;
    checkAll.checked = selCount() === all;
    toggleButtons();
  });

  btnEdit.addEventListener('click', e => {
    e.preventDefault();
    if (selCount() !== 1) return;
    const id = selected()[0].closest('tr').dataset.tableid;
    window.location.href = `/contracts/edit/${id}`;
  });

  btnDelete.addEventListener('click', e => {
    e.preventDefault();
    const ids = selected().map(row => row.closest('tr').dataset.tableid);
    if (ids.length === 0) return;

    idsBorrar.innerHTML = '';
    ids.forEach(id => {
      const inp = document.createElement('input');
      inp.type  = 'hidden';
      inp.name  = 'ids[]';
      inp.value = id;
      idsBorrar.appendChild(inp);
    });

    if (ids.length === 1) {
      mTitle.textContent = 'Eliminar';
      mMsg.innerHTML = `¿Está seguro de que desea eliminar el contrato seleccionado?`;
    } else {
      mTitle.textContent = 'Importante';
      mMsg.textContent = `¿Está seguro de que desea eliminar los ${ids.length} contratos seleccionados?`;
    }

    modal.modal('show');
  });
  toggleButtons();
});
</script>