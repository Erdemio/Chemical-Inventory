<?php
if(!defined('check_for_direct_access')) {
   die('Doğrudan erişim yasaklıdır.<br>Direct access not permitted.');
}
?>
<header>
  <nav>
    <div class="nav-wrapper">
      <div class="row">
        <div class="col m6 hide-on-med-and-down">
          <a href="index" class="breadcrumb">Anasayfa</a>
          <a href="index" class="breadcrumb">Kimyasal Listele</a>
        </div>
        <div class="col m6 s12">
          <a href="#" data-target="nav-mobile" class=" sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
          <a  href="#logoff" class="right modal-trigger"><i class="material-icons">exit_to_app</i></a>
        </div>
      </div>
    </div>
  </nav>
  <ul id="nav-mobile" class="sidenav sidenav-fixed">
    <li><div class="user-view">
      <a href="index"><img class="profil" src="assets/deu.png"></a>
      <span class="userid"><?php echo @$_SESSION['user']; ?></span>
    </div></li>
    <li class="active"><a href="#!" class="waves-effect"><i class="material-icons">view_list</i>Kimyasal Listele</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">mode_edit</i>Kimyasal Düzenle</a></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">add</i>Kimyasal Ekle</a></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">import_export</i>Dışarı Aktar</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#!" class="waves-effect"><i class="material-icons">info</i>Daha fazla</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#logoff" class="waves-effect modal-trigger"><i class="material-icons">exit_to_app</i>Çıkış Yap</a></li>
  </ul>
</header>
