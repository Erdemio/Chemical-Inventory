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
          <a class="dropdown-trigger2 right" href="#!" data-target="dropdown1"><?php echo @$_SESSION['user']; ?><i class="material-icons right">arrow_drop_down</i></a>
        </div>
      </div>
    </div>
  </nav>
  <ul id="dropdown1" class="dropdown-content">
    <li><a  href="settings" class="modal-trigger">Hesap Ayarlarım</a></li>
    <li class="divider"></li>
    <li><a  href="#logoff" class="modal-trigger">Çıkış Yap</a></li>
  </ul>
  <ul id="nav-mobile" class="sidenav sidenav-fixed">
    <li><div class="user-view">
      <a href="index"><img class="profil" src="assets/deu.png"></a>
      <!--<span class="userid"><?php echo @$_SESSION['user']; ?></span>-->
    </div></li>
    <li><div class="divider"></div></li>
    <li <?php if($active == "index"){echo " class=\"active\";";} ?> ><a href="index" class="waves-effect"><i class="material-icons">view_list</i>Kimyasal Listele<span class="new badge blue" data-badge-caption="<?php echo $stock_count1; ?>"></span></a></li>
    <li <?php if($active == "stock"){echo " class=\"active\";";}else if(@$stock_count2<=0){echo " class=\"hide\";";} ?> ><a href="stock" class="waves-effect"><i class="material-icons">list_alt</i>Stokta Olmayanlar<span class="new badge red" data-badge-caption="<?php echo $stock_count2; ?>"></span></a></li>
    <li><div class="divider"></div></li>
    <li <?php if($active == "edit"){echo " class=\"active\";";} ?> ><a href="edit" class="waves-effect"><i class="material-icons">mode_edit</i>Kimyasal Düzenle</a></li>
    <li <?php if($active == "insert"){echo " class=\"active\";";} ?> ><a href="insert" class="waves-effect"><i class="material-icons">add</i>Kimyasal Ekle</a></li>
    <li <?php if($active == "export"){echo " class=\"active\";";} ?> ><a href="export" class="waves-effect"><i class="material-icons">cloud_upload</i>Dışarı Aktar</a></li>
    <li><div class="divider"></div></li>
    <li <?php if($active == "help"){echo " class=\"active\";";} ?> ><a href="help" class="waves-effect"><i class="material-icons">info</i>Daha fazla</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#logoff" class="waves-effect modal-trigger"><i class="material-icons">exit_to_app</i>Çıkış Yap</a></li>
  </ul>
</header>
