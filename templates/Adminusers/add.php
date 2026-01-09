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

$this->layout = 'admin-users-edit';
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
    <div class="properties form large-9 medium-8 columns content">
        <form method="post" action="#" enctype="multipart/form-data">
            <div id="panel_header">
                <h3><?= __('Añadir usuario') ?></h3>
                <div id="action-buttons">
                    <button id="action-save" class="link-action addlink" id="btn-aceptar" type="submit" name="Guardar"
                        value="guardar"><span class="hidden-xs">Guardar</span><i
                            class="material-icons visible-xs-block">save</i></button>
                    <a id="action-del" class="link-action" href="/adminusers"><span class="hidden-xs">Descartar</span><i
                            class="material-icons visible-xs-block">arrow_back</i></a>
                </div>
            </div>
            <div class="container-fluid container-full-blanco container-edit">
                <p class="mandatory-fields-notice">Los campos marcados con asterisco (*) son obligatorios.</p>
                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-left">
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Nombre de usuario *</p>
                            <input type="text" name="username" maxlength="50" id="username">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Rol *</p>
                            <select class="selectform" name="rol" id="rol">
                                <option value="editor" selected>Editor</option>
                                <option value="admin">Administrador</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Email *</p>
                            <input type="email" name="email" maxlength="255" id="email">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Contraseña *</p>
                            <input type="password" name="password" maxlength="20" id="password">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Nombre </p>
                            <input type="text" name="nombre" maxlength="100" id="nombre">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Apellidos </p>
                            <input type="text" name="apellidos" maxlength="150" id="apellidos">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Dirección</p>
                            <input type="text" name="direccion" maxlength="250" id="direccion">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Ciudad</p>
                            <input type="text" name="ciudad" maxlength="100" id="ciudad">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Provincia</p>
                            <input type="text" name="provincia" maxlength="100" id="provincia">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">País</p>
                            <input type="text" name="pais" maxlength="100" id="pais">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Código Postal</p>
                            <input type="text" name="cp" maxlength="5" id="cp">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Telefono</p>
                            <input type="text" name="tlfn" maxlength="15" id="tlfn">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Telefono 2</p>
                            <input type="text" name="tlfn2" maxlength="15" id="tlfn2">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Fax</p>
                            <input type="text" name="fax" maxlength="15" id="fax">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Latitud</p>
                            <input type="text" name="latitud" maxlength="255" id="latitud">
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <p class="dato-titulo">Longitud</p>
                            <input type="text" name="longitud" maxlength="255" id="longitud">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-blanca-right">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <p class="dato-titulo">Imagen *</p>
                            <div class="row">
                                <div id="imagen-principal">
                                    <div class="unElementoGaleria unElementoEdit col-lg-2 col-md-3 col-sm-4 col-xs-12"
                                        style="padding:5px!important; height:130px;">
                                        <div class="unaImagen"
                                            style="background-position: center; background-size: cover; width:100%; height:100%; background-image:url(/img/default/userdefault.jpg)">
                                        </div>
                                        <!-- <img id="delete" class="deletebtn" data-idimg="<?= $user->multimedia->id ?>" src="/img/default/delete.png" style="position: absolute; z-index: 9; top: 8px; right: 9px; height: 30px; display: none;"> -->
                                        <!-- <a target="_blank" href="<?= $user->multimedia->url ?>">
                        <img id="link" src="/img/default/link.png" style="position: absolute; z-index: 9; top: 8px; right: 47px; height: 30px; display: none;">
                      </a> -->
                                    </div>
                                </div>
                                <div id="input-imagen-principal" style="display:none;">
                                    <input type="text" name="imagen-main" value="">
                                </div>
                                <div class="select-image col-lg-8 col-md-7 col-sm-6 col-sx-12">
                                    <p class="dato-titulo">Selecciona una imagen de perfil</p>
                                    <a id="añadir-main" class="link-action" data-toggle="modal"
                                        data-target="#modalImagenMain">Cambiar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalImagenMain" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <h3 aria-hidden="true">&times;</h3>
                </button>
                <h3 class="modal-title">Añadir multimedia</h3>
            </div>
            <div class="modal-body">
                <div class="container-drop drop-editar">
                    <div id="drpz">
                        <div class="dz-message" data-dz-message><span>Arrastra los ficheros aquí para iniciar su
                                subida<br>o haz click.</span></div>
                    </div>
                </div>
                <div id="prueba" class="container-gallery gallery-editar pruebaImagenes">
                    <div id="imagenesmain" class="galeria-addImage container-fluid">
                        <?php foreach ($imageset as $oneimage): ?>
                            <div class="unElementoGaleria col-lg-2 col-md-2 col-sm-4 col-xs-6"
                                style="padding:5px!important; height:130px;">
                                <div id="<?= $oneimage->id ?>" data-nombre="<?= $oneimage->url ?>" class="unaImagen"
                                    style="background-position: center; background-size: cover; width:100%; height:100%; background-image:url('<?= $oneimage->url ?>')">
                                </div>
                                <img id="tick" src="/img/default/tick.png"
                                    style="position: absolute; display: none; z-index: 9; top: 4px; right: 9px; height: 30px;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="enlace-guardar" onClick="joinImageMain()" class="link-action">Asociar imagen como principal</a>

                <button type="button" class="link-action" data-dismiss="modal">Cancelar</button>

            </div>
        </div>
    </div>
</div>