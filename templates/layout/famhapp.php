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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

    <!-- Colores de navegador -->
    <meta name="theme-color" content="#7d8fff">
    <meta name="msapplication-navbutton-color" content="#7d8fff">

    <!-- Icono por defecto  -->
    <?= $this->Html->meta('icon') ?>

    <!-- Fuentes e iconos -->
    <?= $this->Html->css('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap') ?>
    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css') ?>

    <!-- Date picker recursos -->
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js') ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/Draggable.min.js') ?>


    <!-- Estilos-->
    <?= $this->Html->css('famhapp') ?>
    <?= $this->Html->css('date-picker') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="fh-body">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</body>

</html>