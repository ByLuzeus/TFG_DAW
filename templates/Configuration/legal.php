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
    <?= $this->Form->create(null, ['url' => ['controller' => 'Configuration', 'action' => 'legal']]) ?>
    <div id="panel_header">
      <h3><?= __('Textos legales') ?></h3>
      <div id="action-buttons">
        <button class="link-action addlink" type="submit" name="Guardar" value="guardar">
          <span class="hidden-xs"><?= __('Guardar') ?></span>
          <i class="material-icons visible-xs-block">save</i>
        </button>
      </div>
    </div>
    <div class="container-fluid container-full-blanco container-edit">
      <div class="row mb-5">
        <div class="col-lg-12 col-md-12">
          <p class="dato-titulo"><?= __('Política de cookies') ?></p>
          <textarea style="width: 100%;" name="cookies" id="cookies" rows="20"><?= h($cookies->description) ?></textarea>
        </div>
      </div>

      <div class="row mb-5 mt-5">
        <div class="col-lg-12 col-md-12">
          <p class="dato-titulo"><?= __('Política de privacidad') ?></p>
          <textarea style="width: 100%;" name="privacidad" id="privacidad" rows="20"><?= h($privacidad->description) ?></textarea>
        </div>
      </div>

      <div class="row mb-5 mt-5">
        <div class="col-lg-12 col-md-12">
          <p class="dato-titulo"><?= __('Aviso legal') ?></p>
          <textarea style="width: 100%;" name="aviso" id="aviso" rows="20"><?= h($aviso->description) ?></textarea>
        </div>
      </div>
    </div>
    <?= $this->Form->end() ?>
  </div>
</div>