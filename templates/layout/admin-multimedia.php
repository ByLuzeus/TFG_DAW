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
<?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken'), ['type' => 'csrf']) ?>
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') ?>
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') ?>
<?= $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i') ?>
<?= $this->Html->css('https://fonts.googleapis.com/icon?family=Material+Icons') ?>
<?= $this->Html->css('dropzone.css') ?>
<?= $this->Html->css('admin.css') ?>
<?= $this->Html->css('new-admin.css') ?>
</head>
<body>
  <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
</body>
<?= $this->Html->script('tinymce/tinymce.min.js') ?>
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
  Dropzone.autoDiscover = false;

  $(function() {
    var csrfToken = $(\'meta[name="csrfToken"]\').attr(\'content\');

    var myDropzone = new Dropzone("#drpz", {
      url: "/multimedia/uploadmultimedia",
      paramName: "file",           // El campo 'file' es el que leerá el controller
      headers: {
        "X-CSRF-Token": csrfToken  // Enviamos el token en cada petición
      },
      dictDefaultMessage: "Arrastra los ficheros aquí para iniciar su subida",
      maxFilesize: 20,             // Tamaño máximo en MB (ajústalo a tu necesidad)
      acceptedFiles: "image/*,video/*,application/pdf",
      addRemoveLinks: false        // No mostramos el link “Eliminar” nativo de Dropzone
    });

    myDropzone.on("success", function(file, response) {
      myDropzone.removeFile(file);

      $.ajax({
        url: "/multimedia/getmultimedia",
        cache: false,
        success: function(mymedia) {
          $("#lista-multimedia").empty();
          for (var i = 0; i < mymedia.length; ++i) {
            if (mymedia[i].mytype == "image") {
              $("#lista-multimedia").append(
                "<a href=\"/multimedia/edit/" + mymedia[i].id + "\">" +
                  "<div class=\"mult-image\" " +
                    "style=\"background-image:url('" + mymedia[i].url + "'); " +
                           "width:120px; height:120px; " +
                           "background-position:center center; " +
                           "background-repeat:no-repeat; " +
                           "background-size:cover; " +
                           "margin:10px;\" " +
                    "alt=\"" + mymedia[i].alt + "\">" +
                  "</div>" +
                "</a>"
              );
            } else if (mymedia[i].mytype == "video") {
              $("#lista-multimedia").append(
                "<a href=\"/multimedia/edit/" + mymedia[i].id + "\">" +
                  "<video class=\"mult-image\" style=\"width:120px; height:120px; margin:10px;\" preload=\"metadata\">" +
                    "<source src=\"" + mymedia[i].url + "#t=0.1\" type=\"video/" + mymedia[i].extension + "\">" +
                  "</video>" +
                "</a>"
              );
            } else if (mymedia[i].mytype == "document") {
              $("#lista-multimedia").append(
                "<a href=\"/multimedia/edit/" + mymedia[i].id + "\">" +
                  "<div class=\"mult-image\" " +
                    "style=\"background-image:url(\'/img/default/document_icon.jpg\'); " +
                           "width:120px; height:120px; " +
                           "background-position:center center; " +
                           "background-repeat:no-repeat; " +
                           "background-size:cover; " +
                           "margin:10px;\" " +
                    "alt=\"" + mymedia[i].alt + "\">" +
                  "</div>" +
                "</a>"
              );
            }
          }
        }
      });
    });

    myDropzone.on("error", function(file, errorMessage) {
      alert("Error al subir: " + errorMessage);
      myDropzone.removeFile(file);
    });
  });
', ['defer' => true]); ?>



</html>
