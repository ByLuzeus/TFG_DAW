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
  <title><?php echo $this->fetch('title'); ?></title>
  <?= $this->fetch('desc'); ?>
  <?= $this->fetch('tc'); ?>
  <?= $this->fetch('tt'); ?>
  <?= $this->fetch('ti'); ?>
  <?= $this->fetch('td'); ?>
  <?= $this->fetch('tu'); ?>
  <?= $this->fetch('tn'); ?>
  <?= $this->fetch('tcc'); ?>
  <?= $this->fetch('ot'); ?>
  <?= $this->fetch('on'); ?>
  <?= $this->fetch('oy'); ?>
  <?= $this->fetch('oi'); ?>
  <?= $this->fetch('ou'); ?>
  <?= $this->fetch('od'); ?>
  <?= $this->Html->css('web/general.css') ?>
  <?= $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css') ?>
  <?= $this->Html->css('https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css') ?>
  <?= $this->Html->css('https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css') ?>
  <?= $this->Html->css('https://fonts.googleapis.com/icon?family=Material+Icons') ?>
  <?= $this->Html->css('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,600;0,700;0,800;1,400&family=Playfair+Display:ital,wght@0,600;1,600&display=swap') ?>

</head>
    <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
  </div>
  <?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.min.js') ?>
  <?= $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js') ?>
  <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js') ?>
  <?= $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js') ?>
  <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/waypoints/3.0.0/noframework.waypoints.min.js') ?>
  <?= $this->Html->script('https://cdn.kiprotect.com/klaro/v0.7.18/klaro.js') ?>
  <?= $this->Html->script('https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js') ?>
  <?= $this->Html->script('jquery.waypoints.js') ?>
  <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js') ?>
    </body>
</html>
