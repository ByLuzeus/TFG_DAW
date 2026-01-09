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
<?= $this->Html->css('https://use.fontawesome.com/releases/v5.0.6/css/all.css') ?>
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/select/1.2.5/css/select.dataTables.min.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') ?>
<?= $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i') ?>
<?= $this->Html->css('https://fonts.googleapis.com/icon?family=Material+Icons') ?>
<?= $this->Html->css('admin.css') ?>
<?= $this->Html->css('new-admin.css') ?>
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
    $(document).ready(function(){
      var table3=$("#eventos").DataTable({
        "bPaginate": true,
        "info":     false,
        "responsive": true,
        "order": [[ 1, "asc" ]],
        "columnDefs": [
          { "orderable": false, "targets": 0 },
          { "width": "5%", "targets": 0 },
          { "orderable": false, "targets": 5 },
          { "width": "5%", "targets": 5 },
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 1, targets: 1 },
          { responsivePriority: 1, targets: 2 },
          { responsivePriority: 1, targets: -1 }
        ],
        language: {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty":      "No hay registros que mostrar",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}
      });

      $(".search").each( function () {
        var title = $(this).text();
        $(this).html( "<input class=\"tablainput\" type=\"text\" placeholder=\" "+title+"\" />" );
    } );


table3.columns().every( function () {
  var that = this;
  $( "input", this.header() ).click(function( event ) {
    event.stopPropagation();
    if($(this).hasClass("checkPrivacy")){

    }
    // Do something
  });
  $( "input", this.header() ).on( "keyup change", function () {
    if($(this).hasClass("checkPrivacy")){
      if ($(this).is(":checked")) {
        $(".checkRow").prop("checked", true);
        comprobarChecks();
      } else {
        $(".checkRow").prop("checked", false);
        comprobarChecks();
      }
    } else {
      if ( that.search() !== this.value ) {
          that
              .search( this.value )
              .draw();
      }
    }
  } );
} );

$("#eventos").on("change", ".checkRow", function() {
  comprobarChecks();
  var $row = $( this ).closest("tr");
  if ($(this).is(":checked")){
    $("#ids-borrar").append("<input type=\"hidden\" name=\"ids[]\" data-ideliminar=\""+$row.data("tableid")+"\" value=\""+$row.data("tableid")+"\">");
  }
  else {
    $("#ids-borrar :input").filter(function(){return this.value==$row.data("tableid")}).remove();
  }
});

$("#eventos").on("change", ".checkPrivacy", function() {
  comprobarChecks();
  if ($(this).is(":checked")){
    $(".checkRow").each(function() {
          var $row = $( this ).closest("tr");
          if (!$("input[data-ideliminar=\""+$row.data("tableid")+"\"]").val()){
            $("#ids-borrar").append("<input type=\"hidden\" name=\"ids[]\" data-ideliminar=\""+$row.data("tableid")+"\" value=\""+$row.data("tableid")+"\">")
          }
    });
  }
  else {
    $(".checkRow").each(function() {
          var $row = $( this ).closest("tr");
          $("#ids-borrar :input").filter(function(){return this.value==$row.data("tableid")}).remove();
    });
  }
});

table3.on( "draw", function () {
  if ($(".checkRow").length === 0){
    $(".checkPrivacy").prop("checked", false);
    return false;
  }
  else {
    $(".checkRow").each(function() {
          if (!$(this).prop("checked") == true){
            $(".checkPrivacy").prop("checked", false);
            return false;
          }
          else {
            $(".checkPrivacy").prop("checked", true);
          }
    });
  }
} );
    });
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
    function comprobarChecks(){
      if ($(".checkRow:checked").length > 0){
        if ($(".checkRow:checked").length === 1){
          $("#action-edit").removeClass("unactive");
          $("#action-del").removeClass("unactive");
          var $row = $(".checkRow:checked").closest("tr");
          var $text = $row.data("tableid");
          $("#action-edit").attr("href", "/appdatas/edit/" + $text)
        } else {
          $("#action-edit").addClass("unactive");
          $("#action-del").removeClass("unactive");
        }
      } else {
        $(".checkPrivacy").prop("checked", false);
        $("#action-edit").addClass("unactive");
        $("#action-del").addClass("unactive");
      }
    }
', ['defer' => true]); ?>
</html>
