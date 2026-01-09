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

$this->layout = 'admin-dash';
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
          <h3><?= __('Dashboard') ?></h3>
        </div>
        <div class="container-full-grey">
          
          <div class="row">
            <div class="col-lg-6 bCard">
              <p class="titulo">Últimos Artículos</p>
              <table id="dashArtciles" class="" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                    <th class="search">Fecha</th>
                    <th class="search">Título</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($articles as $article): ?>
                    <tr data-tableid="<?= h($article->id) ?>">
                      <td><?= h($article->created->format('d-m-y')) ?></td>
                      <td><?= h($article->title) ?></td>
                      <td class="celdaiconos"><a href="/articles/view/<?= h($article->id) ?>"><i class="material-icons">link</i></a>&nbsp;&nbsp;&nbsp;<a href="/articles/edit/<?= h($article->id) ?>"><i class="material-icons">edit</i></a></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="col-lg-6 bCard">
              <p class="titulo">Últimos registros</p>
              <table id="dashLogs" class="" cellpadding="0" cellspacing="0">
                <thead>
                  <tr>
                    <th class="search">Fecha</th>
                    <th class="search">Usuario</th>
                    <th class="search">Acción</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($logs as $log): ?>
                    <tr data-tableid="<?= h($log->id) ?>">
                      <td><?= h($log->created->format('d-m-y'))?></td>
                      <td><?= h($log->username) ?></td>
                      <td><?= h($log->description) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
