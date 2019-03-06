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
          <a href="<?php echo $link; ?>" class="breadcrumb"><?php echo $page; ?></a>
          <?php echo @$chemical_name; ?>
        </div>
        <div class="col s12 m12 l6">
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
    <li <?php if($active == "index"){echo " class=\"active\";";} ?> ><a href="index" class="waves-effect"><i class="material-icons">view_list</i>Kimyasal Listele</a></li>
    <li><div class="divider"></div></li>
    <li <?php if($active == "edit"){echo " class=\"active\";";} ?> ><a href="edit" class="waves-effect"><i class="material-icons">mode_edit</i>Kimyasal Düzenle</a></li>
    <li <?php if($active == "insert"){echo " class=\"active\";";} ?> ><a href="insert" class="waves-effect"><i class="material-icons">add</i>Kimyasal Ekle</a></li>
    <li <?php if($active == "export"){echo " class=\"active\";";} ?> ><a href="export" class="waves-effect"><i class="material-icons">import_export</i>Dışarı Aktar</a></li>
    <li><div class="divider"></div></li>
    <li <?php if($active == "help"){echo " class=\"active\";";} ?> ><a href="help" class="waves-effect"><i class="material-icons">info</i>Daha fazla</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#logoff" class="waves-effect modal-trigger"><i class="material-icons">exit_to_app</i>Çıkış Yap</a></li>
  </ul>
</header>
