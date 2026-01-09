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

$this->layout = 'admin-multimedia';
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
        <form method="post" action="#" enctype="multipart/form-data">
        <div id="panel_header">
          <h3><?= __('Multimedia') ?></h3>
          <div id="action-buttons">
            <button id="action-save" class="link-action addlink" id="btn-aceptar" type="submit" name="Guardar" value="guardar" ><span class="hidden-xs">Guardar</span><i class="material-icons visible-xs-block">save</i></button>
            <a id="action-del" class="link-action" href="/media"><span class="hidden-xs">Descartar</span><i class="material-icons visible-xs-block">arrow_back</i></a>
            <a id="action-del" data-toggle="modal" data-target="#modalEliminar" class="link-action dellink"><span class="hidden-xs">Eliminar</span><i class="material-icons visible-xs-block">delete</i></a>
          </div>
        </div>
        <div class="container-fluid container-full-blanco container-edit">
          <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
            <div class="row">
              <div class="col-lg-12">
                <?php switch ($multimedia->mytype) {
                    case 'image':
                      echo '<img class="img-responsive" src="'.$multimedia->url.'">';
                      break;
                    case 'video':
                       echo '<video width="100%" preload="metadata"><source src="'.$multimedia->url.'#t=0.1" type="video/mp4"></video>'; //TODO tener cuidado con la extension del video
                      break;
                    case 'document':
                      echo '<img class="img-responsive" src="/img/default/document_icon.jpg">';
                      break;
                    case 'file':
                          # code...
                      break;
                 } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <p class="dato-titulo">Título</p>
                <input type="text" name="titulo" maxlength="200" id="titulo" value="<?= $multimedia->title ?>" >
              </div>
              <div class="col-lg-6 col-md-6">
                <p class="dato-titulo">Alt</p>
                <input type="text" name="alt" maxlength="200" id="alt" value="<?= $multimedia->alt ?>" >
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <p class="dato-titulo">Descripción</p>
                <textarea style="width: 100%;" name="descripcion" id="descripcion" rows="5"><?= $multimedia->description ?></textarea>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><h3 aria-hidden="true">&times;</h3></button>
        <h3 class="modal-title">Eliminar</h3>
      </div>
      <div class="modal-body">
        <p class="modal-mensaje">¿Estás seguro de eliminar esta imagen?</p>
      </div>
      <div class="modal-footer">
        <form method="post" action="/multimedia/delete/<?= $multimedia->id ?>">
          <button type="button" class="link-action" data-dismiss="modal">Volver</button>
          <button id="enlace-eliminar" type="submit" class="link-action dellink">Eliminar</a>
        </form>
      </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
