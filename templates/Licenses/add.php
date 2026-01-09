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
$cakeDescription = __('FamHapp - Dashboard, Panel de administración');
?>
<div class="metas">
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>
<?= $menuadmin ?>

<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties form large-9 medium-8 columns content">
    <?= $this->Form->create(null, ['id' => 'license-form']) ?>

    <div id="panel_header">
      <h3><?= __('Añadir licencias') ?></h3>
      <div id="action-buttons">
        <button id="action-save" class="link-action addlink" type="submit" name="Guardar" value="guardar">
          <span class="hidden-xs">Crear</span><i class="material-icons visible-xs-block">save</i>
        </button>
        <a id="action-del" class="link-action" href="/licenses">
          <span class="hidden-xs">Descartar</span><i class="material-icons visible-xs-block">arrow_back</i>
        </a>
      </div>
    </div>

    <div class="container-fluid container-full-blanco container-edit">
      <p class="mandatory-fields-notice">Los campos marcados con asterisco (*) son obligatorios.</p>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
        <div class="row mb-2">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo">Email asociado *</p>
            <input
              type="email"
              name="email"
              maxlength="255"
              id="email"
              required
            >
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-lg-12 col-md-12">
            <p class="dato-titulo">Usuario *</p>
            <select class="selectform" name="username" id="username">
              <option value="" data-email=""><?= __('Usuario no registrado') ?></option>
            </select>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-lg-6 col-md-12">
            <p class="dato-titulo">Número de licencias *</p>
            <select class="selectform" name="licensesnumber" id="licensesnumber">
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right"></div>
    </div>

    <?= $this->Form->end() ?>
  </div>
</div>

<?php
$searchUrl = $this->Url->build(
  ['controller' => 'Licenses', 'action' => 'emailSearch'],
  ['escape' => false]
);
?>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const emailInp = document.getElementById('email');
    const userSel = document.getElementById('username');

    function clearOptions() {
      userSel.innerHTML = '';
      userSel.add(new Option('Usuario no registrado', ''));
      userSel.selectedIndex = 0;
    }

    function fillUsers(list) {
      clearOptions();
      list.forEach(u => {
        const opt = new Option(u.name + ' (' + u.username + ')', u.username);
        userSel.add(opt);
      });
    }

    function searchUsers() {
      const term = emailInp.value.trim();
      if (term.length < 3) {
        clearOptions();
        return;
      }

      fetch('<?= $searchUrl ?>?email=' + encodeURIComponent(term), {
        headers: { 'Accept': 'application/json' }
      })
        .then(r => r.ok ? r.json() : { users: [] })
        .then(data => fillUsers(data.users || []))
        .catch(() => clearOptions());
    }
    emailInp.addEventListener('input', searchUsers);
  });
</script>