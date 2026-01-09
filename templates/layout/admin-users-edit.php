<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--
  <-- Chrome, Firefox OS, Opera and Vivaldi --
  <meta name="theme-color" content="#4c7c1b">
  <!-- Windows Phone --
  <meta name="msapplication-navbutton-color" content="#4c7c1b">
  <!-- iOS Safari --
  <meta name="apple-mobile-web-app-status-bar-style" content="#4c7c1b">
  -->
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') ?>
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') ?>
<?= $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i') ?>
<?= $this->Html->css('https://fonts.googleapis.com/icon?family=Material+Icons') ?>
<?= $this->Html->css('admin.css') ?>
<?= $this->Html->css('new-admin.css') ?>
<?= $this->Html->css('dropzone.css') ?>

</head>
<body>
  <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
</body>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') ?>
<?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js') ?>
<?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') ?>
<?= $this->Html->script('https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js') ?>
<?= $this->Html->script('https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js') ?>
<?= $this->Html->script('common.js') ?>
<?= $this->Html->script('dropzone.js') ?>

<?= $this->Html->scriptBlock('
    $("#fastadd").click(
    function(){
      $(".container-full-blanco").fadeToggle();
    })
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
    $("form").on("keyup keypress", function(e) {
      var keyCode = e.keyCode || e.which;
      if (keyCode === 13) {
        e.preventDefault();
        return false;
      }
    });
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
    var myDropzone = new Dropzone("#drpz", {
      url: "/multimedia/uploadmultimedia",
    });
    myDropzone.options.dictDefaultMessage = "Arrastra los ficheros aquí para iniciar su subida";

    myDropzone.on("complete", function(file) {
       myDropzone.removeFile(file);

      $.ajax({
            url: "/multimedia/getimages",
            cache: false,
            success: function(myimages){
              $(".galeria-addImage").empty();

              for (i = 0; i < myimages.length; ++i) {
                $(".galeria-addImage").append("<div class=\"unElementoGaleria col-lg-2 col-md-3 col-sm-4 col-xs-12\" style=\"padding:5px!important; height:130px;\"><div id=\""+myimages[i].id+"\" data-nombre=\""+myimages[i].url+"\" class=\"unaImagen\" style=\"background-position: center; background-size: cover; width:100%; height:100%; background-image:url("+myimages[i].url+")\"></div><img id=\"tick\" src=\"/img/default/tick.png\" style=\"position: absolute; display: none; z-index: 9; top: 4px; right: 9px; height: 30px;\"></div>");
               }
            }
          })
      });


', ['defer' => true]); ?>

<?= $this->Html->scriptBlock('
$("#modalImagenMain .galeria-addImage").on("click", ".unElementoGaleria", function() {
  if ($selected = $("#modalImagenMain .galeria-addImage").find(".selected-img")){
    $selected.toggleClass("selected-img");
    $selected.parent().find("#tick").toggle();
  }
  $(this).find(".unaImagen").toggleClass("selected-img");
  $(this).find("#tick").toggle();
});
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
function joinImageMain(){
  limpiarImagenMain();
  var nombres = [];
  var ids = [];
  $(".selected-img").each(function(i) {
    nombres.push($(this).attr("data-nombre"));
    ids.push($(this).attr("id"));
  });
  var i;
  for (i = 0; i < nombres.length; ++i) {
    var ImagenNombre = nombres[i];
    var imagenID = ids[i];
    var newEl = "<div id=\""+imagenID+"\" class=\"unElementoGaleria unElementoEdit col-lg-2 col-md-3 col-sm-4 col-xs-12\" style=\"padding:5px!important; height:130px;\"><div class=\"unaImagen\" style=\"background-position: center; background-size: cover; width:100%; height:100%; background-image:url("+ImagenNombre+")\"></div><img id=\"delete\" class=\"deletebtn\" data-idimg=\""+imagenID+"\" src=\"/img/default/delete.png\" style=\"position: absolute; display:none; z-index: 9; top: 8px; right: 9px; height: 30px;\"><a target=\"_blank\" href=\""+ImagenNombre+"\"><img id=\"link\" src=\"/img/default/link.png\" style=\"position: absolute; display:none; z-index: 9; top: 8px; right: 47px; height: 30px;\"></a></div>";
    var newElInput = "<input type=\"text\" id=\""+imagenID+"\" name=\"imagen-main\" value=\""+imagenID+"\">";
    $("#imagen-principal").append(newEl);
    $("#input-imagen-principal").append(newElInput);
  }
  desseleccionarTodas();
  ids = [];
  nombres = [];
  $("#modalImagenMain").modal("toggle");
}
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
  $("#imagen-principal").on("mouseenter", ".unElementoEdit", function() {
    $(this).find(".unaImagen").toggleClass("selected-img");
    $(this).find("#delete").toggle();
    $(this).find("#link").toggle();
  });
  $("#imagen-principal").on("mouseleave", ".unElementoEdit", function() {
    $(this).find(".unaImagen").toggleClass("selected-img");
    $(this).find("#delete").toggle();
    $(this).find("#link").toggle();
  });
  $("#imagen-principal").on("click", ".deletebtn", function() {
    var id = "#" + $(this).attr("data-idimg");
    $(id).remove();
    $(id).remove();
  });
', ['defer' => true]); ?>

<?= $this->Html->scriptBlock('
    function limpiarImagenMain(){
      $("#imagen-principal").empty();
      $("#input-imagen-principal").empty();
    }
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
    function desseleccionarTodas(){
      $( ".unElementoGaleria" ).each(function() {
        if ($(this).find(".unaImagen").hasClass("selected-img")){
          $(this).find(".unaImagen").toggleClass("selected-img");
          $(this).find("#tick").toggle();
        }
      });
    }
', ['defer' => true]); ?>

<?= $this->Html->scriptBlock('
    function addNetwork(){
      var lanet = $("#elnetwork").find(":selected").text();
      var netId = $("#elnetwork").find(":selected").attr("value");
      var neturl = $("#laurl").val();

      $("#laurl").val("");

      var newDisc = "<div class=\"row row-network\"><div class=\"col-lg-4 col-md-4\"><p class=\"dato-titulo\">"+lanet+"</p><input type=\"hidden\" name=\"networks_ids[]\" id=\"networks_ids\"  value=\""+netId+"\"></div><div class=\"col-lg-6 col-md-4\"><p class=\"dato-titulo\">"+neturl+"</p><input type=\"hidden\" name=\"networks_urls[]\" id=\"networks_urls\" value=\""+neturl+"\"></div><div class=\"col-lg-2 col-md-2\"><button style=\"bottom:0px;\" id=\"deleterow\"type=\"button\" class=\"btn btn-danger btn-disc btn-disc-del\">Eliminar</button></div></div>";

      $("#networks-space").append(newDisc);

    }
', ['defer' => true]); ?>

<?= $this->Html->scriptBlock('
    $("#networks-space").on( "click", "#deleterow", function (e) {
      var $row = $(this).closest(".row");
      $row.remove();
    } );
', ['defer' => true]); ?>

</html>
