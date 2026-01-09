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
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!--
  <-- Chrome, Firefox OS, Opera and Vivaldi -->
  <meta name="theme-color" content="#4c7c1b">
  <!-- Windows Phone -->
  <meta name="msapplication-navbutton-color" content="#4c7c1b">
  <!-- iOS Safari --
  <meta name="apple-mobile-web-app-status-bar-style" content="#4c7c1b">
  -->
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css') ?>
<?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css') ?>
<?= $this->Html->css('http://cdn.datatables.net/plug-ins/a5734b29083/integration/bootstrap/3/dataTables.bootstrap.css') ?>
<?= $this->Html->css('http://cdn.datatables.net/responsive/1.0.2/css/dataTables.responsive.css') ?>
<?= $this->Html->css('https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css') ?>
<?= $this->Html->css('https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,500i,700,700i') ?>
<?= $this->Html->css('new-admin') ?>
</head>
<body>
  <?= $this->Flash->render() ?>
      <?= $this->fetch('content') ?>
</body>
<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') ?>
<?= $this->Html->script('http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js') ?>
<?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js') ?>
<?= $this->Html->script('https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js') ?>
<?= $this->Html->script('https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js') ?>
<?= $this->Html->scriptBlock('
    var movimientoHorizontal = 260;
    $("#toggle").click(
    function(){
    if ($("#micontent").hasClass("shown")) {
        $("#micontent").toggleClass("shown")
        $("#micontent").animate({left: 0})
        $("#miheader").animate({left: 0})
        movimientoHorizontal = 0;
      }
      else {
        $("#micontent").toggleClass("shown")
        $("#micontent").animate({left: 260})
        $("#miheader").animate({left: 260})
        movimientoHorizontal = 260;
      }
    })
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
    $("#fastadd").click(
    function(){
      $(".container-full-blanco").fadeToggle();
    })
', ['defer' => true]); ?>
<?= $this->Html->scriptBlock('
    // $("form").on("keyup keypress", function(e) {
    //   var keyCode = e.keyCode || e.which;
    //   if (keyCode === 13) {
    //     e.preventDefault();
    //     return false;
    //   }
    // });
    $("form").each(function() {
        $(this).find("input").keypress(function(e) {
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                this.form.submit();
            }
        });
    });
', ['defer' => true]); ?>

</html>
