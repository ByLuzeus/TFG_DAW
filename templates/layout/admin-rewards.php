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
<?php
echo $this->Html->scriptBlock('
  $("form").on("keyup keypress", function(e) {
    var keyCode = e.keyCode || e.which;
    if (keyCode === 13) {
      e.preventDefault();
      return false;
    }
  });
', ['defer' => true]);
?>

<?php
echo $this->Html->scriptBlock('
  $(document).ready(function(){
    if ($("#eventos").length) {
      var table3 = $("#eventos").DataTable({
        bPaginate:    true,
        info:         false,
        responsive:   true,
        order: [[ 1, "asc" ]],
        columnDefs: [
          // Columna 0 (checkbox) no ordenable
          { orderable: false, targets: 0 },
          { width: "5%",    targets: 0 },
          // Última columna (acciones “Editar” / “Ver +”) no ordenable
          { orderable: false, targets: -1 },
          { width: "5%",    targets: -1 },
          // Priorizamos las columnas para responsive
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: 1 },
          { responsivePriority: 3, targets: 2 },
          { responsivePriority: 4, targets: 3 },
          { responsivePriority: 1, targets: -1 }
        ],
        language: {
          sProcessing:     "Procesando...",
          sLengthMenu:     "Mostrar _MENU_ registros",
          sZeroRecords:    "No se encontraron resultados",
          sEmptyTable:     "Ningún dato disponible en esta tabla",
          sInfo:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty:      "No hay registros que mostrar",
          sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
          sSearch:         "Buscar:",
          oPaginate: {
            sFirst:    "Primero",
            sLast:     "Último",
            sNext:     "Siguiente",
            sPrevious: "Anterior"
          },
          oAria: {
            sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
            sSortDescending: ": Activar para ordenar la columna de manera descendente"
          }
        }
      });

      // Insertar inputs de búsqueda por columna en cada <th class="search">
      $(".search").each(function () {
        var title = $(this).text();
        $(this).html("<input class=\"tablainput\" type=\"text\" placeholder=\" " + title + "\" />");
      });

      // Aplicar búsqueda individual en cada columna
      table3.columns().every(function () {
        var that = this;
        $("input", this.header()).on("keyup change", function () {
          if (!$(this).hasClass("checkPrivacy")) {
            if (that.search() !== this.value) {
              that.search(this.value).draw();
            }
          }
        });
      });

      // Función que habilita/deshabilita los botones Editar y Eliminar
      function comprobarChecks() {
        var checkedCount = $(".checkRow:checked").length;
        if (checkedCount > 0) {
          $("#action-del").removeClass("unactive");
          if (checkedCount === 1) {
            $("#action-edit").removeClass("unactive");
            var idSel = $(".checkRow:checked").closest("tr").data("tableid");
            $("#action-edit").attr("href", window.location.pathname.replace(/\\/index$/, "") + "/edit/" + idSel);
          } else {
            $("#action-edit").addClass("unactive");
          }
        } else {
          $(".checkPrivacy").prop("checked", false);
          $("#action-edit").addClass("unactive");
          $("#action-del").addClass("unactive");
        }
      }

      // Al marcar/desmarcar un checkbox de fila
      $("#eventos").on("change", ".checkRow", function() {
        var $row = $(this).closest("tr");
        if ($(this).is(":checked")) {
          // Añadimos un <input type="hidden"> en el formulario de eliminación
          $("#ids-borrar")
            .append("<input type=\"hidden\" name=\"ids[]\" data-ideliminar=\"" + $row.data("tableid") + "\" value=\"" + $row.data("tableid") + "\">");
        } else {
          // Lo quitamos
          $("#ids-borrar input").filter(function() {
            return this.value == $row.data("tableid");
          }).remove();
        }
        comprobarChecks();
      });

      $("#eventos").on("change", ".checkPrivacy", function() {
        var isChecked = $(this).is(":checked");
        $(".checkRow").each(function() {
          var $row = $(this).closest("tr");
          $(this).prop("checked", isChecked);
          if (isChecked) {
            // Añadimos hidden si no existe
            if (!$("#ids-borrar input[data-ideliminar=\"" + $row.data("tableid") + "\"]").length) {
              $("#ids-borrar")
                .append("<input type=\"hidden\" name=\"ids[]\" data-ideliminar=\"" + $row.data("tableid") + "\" value=\"" + $row.data("tableid") + "\">");
            }
          } else {
            // Eliminamos cualquier hidden asociado
            $("#ids-borrar input").filter(function() {
              return this.value == $row.data("tableid");
            }).remove();
          }
        });
        comprobarChecks();
      });

      table3.on("draw", function() {
        if ($(".checkRow").length === 0) {
          $(".checkPrivacy").prop("checked", false);
          return;
        }
        var allChecked = true;
        $(".checkRow").each(function() {
          if (!$(this).prop("checked")) {
            allChecked = false;
            return false;
          }
        });
        $(".checkPrivacy").prop("checked", allChecked);
      });

      comprobarChecks();
    }
  });
', ['defer' => true]);
?>

</html>