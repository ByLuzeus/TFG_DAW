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
  <title><?= $cakeDescription ?></title>
  <?= $this->Html->meta('icon') ?>
</div>

<?= $menuadmin ?>

<div id="micontent" class="shown">
  <?= $headeradmin ?>

  <div class="properties index large-9 medium-8 columns content">
    <div id="panel_header">
      <h3><?= __('Multimedia') ?></h3>
      <div id="action-buttons">
        <a id="action-add" class="link-action" data-toggle="modal" data-target="#modalImagenMain">
          <span class="hidden-xs"><?= __('Añadir') ?></span>
          <i class="material-icons visible-xs-block">add</i>
        </a>
      </div>
    </div>

    <div id="lista-multimedia" class="container-full-blanco" style="display:block;">
      <?php foreach ($multimedia as $media): ?>
        <?php switch ($media->mytype):
          case 'image': ?>
            <a href="<?= $this->Url->build(['controller' => 'Multimedia', 'action' => 'edit', $media->id]) ?>">
              <div
                class="mult-image"
                style="
                  background-image: url('<?= h($media->url) ?>');
                  width: 120px;
                  height: 120px;
                  background-position: center center;
                  background-repeat: no-repeat;
                  background-size: cover;
                  margin: 10px;
                "
                alt="<?= h($media->alt) ?>"
              ></div>
            </a>
            <?php break; ?>

          <?php case 'video': ?>
            <a href="<?= $this->Url->build(['controller' => 'Multimedia', 'action' => 'edit', $media->id]) ?>">
              <video
                class="mult-image"
                style="width: 120px; height: 120px; margin: 10px;"
                preload="metadata"
              >
                <source src="<?= h($media->url) ?>#t=0.1" type="video/mp4">
              </video>
            </a>
            <?php break; ?>

          <?php case 'document': ?>
            <a href="<?= $this->Url->build(['controller' => 'Multimedia', 'action' => 'edit', $media->id]) ?>">
              <div
                class="mult-image"
                style="
                  background-image: url('/img/default/document_icon.jpg');
                  width: 120px;
                  height: 120px;
                  background-position: center center;
                  background-repeat: no-repeat;
                  background-size: cover;
                  margin: 10px;
                "
                alt="<?= h($media->title) ?>"
              >
                <p class="pdfnameupload"><?= h($media->title) ?></p>
              </div>
            </a>
            <?php break; ?>

          <?php case 'file': ?>
            <!-- Otros -->
            <?php break; ?>

        <?php endswitch; ?>
      <?php endforeach; ?>

      <?php
        $paginator = $this->Paginator;
        echo "<div class='paging'>";
        echo $paginator->first('Primera') . ' ';
        if ($paginator->hasPrev()) {
          echo $paginator->prev('&laquo;');
        }
        echo $paginator->numbers(['modulus' => 3]);
        if ($paginator->hasNext()) {
          echo $paginator->next('&raquo;');
        }
        echo $paginator->last('Última');
        echo "</div>";
      ?>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalImagenMain" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <h3 aria-hidden="true">&times;</h3>
        </button>
        <h3 class="modal-title"><?= __('Añadir multimedia') ?></h3>
      </div>
      <div class="modal-body">
        <p class="descripcion">
          <?= __('Caracteres válidos en los nombres de archivo de las imágenes: Letras A - Z, números 0 - 9 y algunos caracteres extra ( . , - , _)')
             ?><br>
          <?= __('Si tiene algún otro caracter no aceptado puede que el archivo multimedia no se suba al servidor.') ?>
        </p>
        <div class="container-drop drop-editar">
          <div id="drpz">
            <div class="dz-message" data-dz-message>
              <span><?= __('Arrastra los ficheros aquí para iniciar su subida.') ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="link-action" data-dismiss="modal"><?= __('Cancelar') ?></button>
      </div>
    </div>
  </div>
</div>