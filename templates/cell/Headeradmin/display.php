<div id="miheader">
  <img class="hidden-xs" id="logo-cabecera" src="/img/nuevo/famhappP.png">
  <button id="toggle" class="button-toggle"><i class="fa fa-bars" aria-hidden="true"></i></button>
  <div class="logout" style="display:block;" data-toggle="collapse" data-target="#usercollapse">
    <div style="margin: 7% 0; width:36px; height:60%; float:left; border-radius: 50%; background-image: url(<?= $img->url ?>); background-position:center center; background-size:cover;"></div>
    <p class="username"><?= $userdata['username'] ?> <img class="flechaUser" src="/img/flecha_gris.png"></p>
  </div>
</div>
<div id="usercollapse" class="menuUser collapse">
  <ul class="listamenu menuUserLista">
    <a href="/users/view/<?= $userdata['id'] ?>"><li>Mi perfil</li></a>
    <a href="/logout"><li>Cerrar sesión</li></a>
  </ul>
</div>
