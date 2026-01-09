<div id="mimenu">
  <?php if ($seccion == "dashboard") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">dashboard</i>Home<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="homemenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#homemenu" class="menuHead"><i class="material-icons">dashboard</i>Home<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="homemenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
        if ($seccion == "dashboard") {
          echo "<a href=\"/dash\"><li class=\"active\">Dashboard</li></a>";
        } else {
          echo "<a href=\"/dash\"><li>Dashboard</li></a>";
        }
      ?>
    </ul>
  </div>

  <?php if ($seccion == "usersapp" || $seccion == "contracts" || $seccion == "removes" || $seccion == "licenses") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">diversity_1</i>Gestión de usuarios<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="ventmenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#ventmenu" class="menuHead"><i class="material-icons">diversity_1</i>Gestión de usuarios<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="ventmenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
      if ($seccion == "usersapp") {
        echo "<a href=\"/users\"><li class=\"active\">Usuarios de la app</li></a>";
      } else {
        echo "<a href=\"/users\"><li>Usuarios de la app</li></a>";
      }
      if ($seccion == "contracts") {
        echo "<a href=\"/contracts\"><li class=\"active\">Contratos</li></a>";
      } else {
        echo "<a href=\"/contracts\"><li>Contratos</li></a>";
      }
      if ($seccion == "removes") {
        echo "<a href=\"/removes\"><li class=\"active\">Solicitudes de eliminación</li></a>";
      } else {
        echo "<a href=\"/removes\"><li>Solicitudes de eliminación</li></a>";
      }
      if ($seccion == "licenses") {
        echo "<a href=\"/licenses\"><li class=\"active\">Licencias</li></a>";
      } else {
        echo "<a href=\"/licenses\"><li>Licencias</li></a>";
      }
      ?>
    </ul>
  </div>

  <?php if ($seccion == "appdatas" || $seccion == "def_rewards" || $seccion == "def_rewardtypes" || $seccion == "def_notiftypes" || $seccion == "def_commitmenttypes" || $seccion == "def_commitments" || $seccion == "def_levels") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">app_shortcut</i>Recursos de la APP<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="defsmenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#defsmenu" class="menuHead"><i class="material-icons">app_shortcut</i>Recursos de la APP<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="defsmenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
      if ($seccion == "appdatas") {
        echo "<a href=\"/appdatas\"><li class=\"active\">Catálogo de APPs</li></a>";
      } else {
        echo "<a href=\"/appdatas\"><li>Catálogo de APPs</li></a>";
      }
      if ($seccion == "def_rewards") {
        echo "<a href=\"/rewards\"><li class=\"active\">Recompensas</li></a>";
      } else {
        echo "<a href=\"/rewards\"><li>Recompensas</li></a>";
      }
      if ($seccion == "def_rewardtypes") {
        echo "<a href=\"/rewardsconsequencestypes\"><li class=\"active\">Tipos de recompensa</li></a>";
      } else {
        echo "<a href=\"/rewardsconsequencestypes\"><li>Tipos de recompensa</li></a>";
      }
      if ($seccion == "def_notiftypes") {
        echo "<a href=\"/notifications\"><li class=\"active\">Tipos de notificación</li></a>";
      } else {
        echo "<a href=\"/notifications\"><li>Tipos de notificación</li></a>";
      }
      if ($seccion == "def_commitmenttypes") {
        echo "<a href=\"/commitmenttypes\"><li class=\"active\">Tipos de compromiso</li></a>";
      } else {
        echo "<a href=\"/commitmenttypes\"><li>Tipos de compromiso</li></a>";
      }
      if ($seccion == "def_commitments") {
        echo "<a href=\"/commitments\"><li class=\"active\">Compromisos</li></a>";
      } else {
        echo "<a href=\"/commitments\"><li>Compromisos</li></a>";
      }
      if ($seccion == "def_levels") {
        echo "<a href=\"/levels\"><li class=\"active\">Niveles</li></a>";
      } else {
        echo "<a href=\"/levels\"><li>Niveles</li></a>";
      }
      ?>
    </ul>
  </div>

  <?php if ($seccion == "multimedia") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">insert_photo</i>Multimedia<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="multmenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#multmenu" class="menuHead"><i class="material-icons">insert_photo</i>Multimedia<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="multmenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
        if ($seccion == "multimedia") {
          echo "<a href=\"/media\"><li class=\"active\">Todos los archivos</li></a>";
        } else {
          echo "<a href=\"/media\"><li>Todos los archivos</li></a>";
        }
      ?>
    </ul>
  </div>
  <?php if ($seccion == "usuarios-index" || $seccion == "usuarios-mi-perfil" || $seccion == "usuarios-add") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">admin_panel_settings</i>Administradores<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="usermenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#usermenu" class="menuHead"><i class="material-icons">admin_panel_settings</i>Administradores<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="usermenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
        if ($seccion == "usuarios-index") {
          echo "<a href=\"/adminusers\"><li class=\"active\">Todos los usuarios</li></a>";
        }else {
          echo "<a href=\"/adminusers\"><li>Todos los usuarios</li></a>";
        }
        if ($seccion == "usuarios-add") {
          echo "<a href=\"/adminusers/add\"><li class=\"active\">Añadir</li></a>";
        }else {
          echo "<a href=\"/adminusers/add\"><li>Añadir</li></a>";
        }

      ?>
    </ul>
  </div>

  <?php if ($seccion == "logs") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">report_problem</i>Registro<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="logmenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#logmenu" class="menuHead"><i class="material-icons">report_problem</i>Registro<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="logmenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
        if ($seccion == "logs") {
          echo "<a href=\"/logs\"><li class=\"active\">Ver logs</li></a>";
        } else {
          echo "<a href=\"/logs\"><li>Ver logs</li></a>";
        }
      ?>
    </ul>
  </div>

  <?php if ($seccion == "configuracion" || $seccion == "conf-contact" || $seccion == "conf-legal" || $seccion == "conf-uso" || $seccion == "updates") { ?>
    <p class="menuHead" aria-expanded="true"><i class="material-icons">settings</i>Configuración<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse in" id="confmenu" aria-expanded="true">
  <?php } else { ?>
    <p data-toggle="collapse" data-target="#confmenu" class="menuHead"><i class="material-icons">settings</i>Configuración<img class="flechaUser" src="/img/flecha_oscuro.png"></p>
    <div class="collapse" id="confmenu">
  <?php } ?>
    <ul class="listamenu">
      <?php
        if ($seccion == "conf-contact") {
          echo "<a href=\"/configuration/contacto\"><li class=\"active\">Contacto</li></a>";
        } else {
          echo "<a href=\"/configuration/contacto\"><li>Contacto</li></a>";
        }
        if ($seccion == "conf-legal") {
          echo "<a href=\"/configuration/legal\"><li class=\"active\">Textos legales</li></a>";
        } else {
          echo "<a href=\"/configuration/legal\"><li>Textos legales</li></a>";
        }
      ?>
    </ul>
  </div>
  </div>
