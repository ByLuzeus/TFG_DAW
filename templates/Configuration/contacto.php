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

$this->layout = 'admin-configuration';
$cakeDescription = __('FamHapp - Dashboard, Panel de adminsitración');
?>
<div class="metas">
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>
<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties form large-9 medium-8 columns content">
    <?= $this->Form->create($contacto, ['id' => 'frm-contacto']) ?>

      <div id="panel_header">
        <h3><?= __('Datos de contacto') ?></h3>
        <div id="action-buttons">
          <?= $this->Form->button(
            '<span class="hidden-xs">'.__('Guardar').'</span><i class="material-icons visible-xs-block">save</i>',
            ['class' => 'link-action addlink','escapeTitle'=>false]
          ) ?>
        </div>
      </div>

      <div class="container-fluid container-full-blanco container-edit">
        <div class="col-lg-6 col-blanca-left">

          <div class="row">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Email *') ?></p>
              <input type="email" name="email" maxlength="255" required value="<?= h($contacto->email) ?>">
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Dirección') ?></p>
              <input type="text" name="address" maxlength="250" value="<?= h($contacto->address) ?>">
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Ciudad') ?></p>
              <input type="text" name="city" maxlength="100" value="<?= h($contacto->city) ?>">
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Provincia') ?></p>
              <input type="text" name="state" maxlength="100" value="<?= h($contacto->state) ?>">
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('País') ?></p>
              <input type="text" name="country" maxlength="100" value="<?= h($contacto->country) ?>">
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Código Postal') ?></p>
              <input type="text" name="cp" maxlength="6" value="<?= h($contacto->cp) ?>">
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Teléfono') ?></p>
              <input type="text" name="tlfn" maxlength="15" value="<?= h($contacto->tlfn) ?>">
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Teléfono 2') ?></p>
              <input type="text" name="tlfn2" maxlength="15" value="<?= h($contacto->tlfn2) ?>">
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Fax') ?></p>
              <input type="text" name="fax" maxlength="15" value="<?= h($contacto->fax) ?>">
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Latitud') ?></p>
              <input type="text" name="latitude" maxlength="255" value="<?= h($contacto->latitude) ?>">
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('Longitud') ?></p>
              <input type="text" name="longitude" maxlength="255" value="<?= h($contacto->longitude) ?>">
            </div>
          </div>

          <hr>

          <div class="row" id="row-networks">
            <div class="col-lg-4 col-md-12">
              <p class="dato-titulo"><?= __('RED') ?></p>
              <select class="selectform" id="elnetwork">
                <?php foreach ($networksset as $net): ?>
                  <option value="<?= h($net->id) ?>"><?= h($net->name) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-lg-6 col-md-12">
              <p class="dato-titulo"><?= __('URL') ?></p>
              <input type="text" id="laurl" maxlength="255">
            </div>
            <div class="col-lg-2 col-md-12">
              <p class="dato-titulo">&nbsp;</p>
              <button type="button" class="btn btn-default btn-disc" id="btn-add-net"><?= __('Añadir') ?></button>
            </div>
          </div>

          <div id="networks-space" class="mt-2">
            <?php foreach ($contacto->networks as $red): ?>
              <div class="row row-network mt-2">
                <div class="col-lg-4 col-md-4">
                  <p class="dato-titulo"><?= h($red->name) ?></p>
                  <input type="hidden" name="networks_ids[]" value="<?= h($red->id) ?>">
                </div>
                <div class="col-lg-6 col-md-4">
                  <p class="dato-titulo"><?= h($red->_joinData->url) ?></p>
                  <input type="hidden" name="networks_urls[]" value="<?= h($red->_joinData->url) ?>">
                </div>
                <div class="col-lg-2 col-md-2">
                  <button type="button" class="btn btn-danger btn-disc btn-del-net"><?= __('Eliminar') ?></button>
                </div>
              </div>
            <?php endforeach; ?>
          </div>

        </div>
      </div>

    <?= $this->Form->end() ?>
  </div>
</div>

<script>
document.getElementById('btn-add-net').addEventListener('click', () => {
  const sel   = document.getElementById('elnetwork');
  const url   = document.getElementById('laurl').value.trim();
  if (!url) { alert('<?= __('Debes indicar la URL.') ?>'); return; }
  const row = document.createElement('div');
  row.className = 'row row-network mt-2';
  row.innerHTML =
    '<div class="col-lg-4 col-md-4"><p class="dato-titulo">'+sel.options[sel.selectedIndex].text+'</p>'+
    '<input type="hidden" name="networks_ids[]" value="'+sel.value+'"></div>'+
    '<div class="col-lg-6 col-md-4"><p class="dato-titulo">'+url+'</p>'+
    '<input type="hidden" name="networks_urls[]" value="'+url+'"></div>'+
    '<div class="col-lg-2 col-md-2"><button type="button" class="btn btn-danger btn-disc btn-del-net"><?= __('Eliminar') ?></button></div>';
  document.getElementById('networks-space').appendChild(row);
  document.getElementById('laurl').value = '';
});

document.addEventListener('click', e => {
  if (e.target && e.target.classList.contains('btn-del-net')) {
    e.target.closest('.row-network').remove();
  }
});
</script>