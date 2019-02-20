<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
?>
<!DOCTYPE html>
  <html>
    <head>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="css/custom.css"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
      <link rel="icon" href="assets/favicon.ico" type="image/x-icon"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta http-equiv="content-language" content="tr">
      <title>Anasayfa</title>
    </head>
    <body>
      <header>
        <nav>
          <div class="nav-wrapper">
            <div class="row">
              <div class="col m8  hide-on-med-and-down">
                <a href="index" class="breadcrumb">Anasayfa</a>
                <a href="#!" class="breadcrumb">Alt Sayfa</a>
                <a href="#!" class="breadcrumb">Alt Sayfa</a>
              </div>
              <div class="col m4 s12">
                <a href="#" data-target="nav-mobile" class=" sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
                <a  href="#logoff" class="right modal-trigger"><i class="material-icons">exit_to_app</i></a>
              </div>
            </div>
          </div>
        </nav>
        <ul id="nav-mobile" class="sidenav  sidenav-fixed">
          <li><div class="user-view">
            <a href="index"><img class="profil" src="assets/deu.png"></a>
            <span class="userid"><?php echo @$_SESSION['user']; ?></span>
          </div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>Kimyasal Listele</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>Kimyasal Düzenle</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>Kimyasal Ekle</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>Dışarı Aktar</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>5</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>6</a></li>
          <li><a href="#logoff" class="waves-effect modal-trigger"><i class="material-icons">exit_to_app</i>Çıkış Yap</a></li>
        </ul>
      </header>
      <main>
        <div class="container">
          <div class="row">
            <div class="col m12">
              <span>Al<sub>2</sub>(SO<sub>4</sub>)<sub>3</sub></span>
            </div>
          </div>
        </div>
      </main>

      <div id="logoff" class="modal mlogoff">
        <div class="modal-content">
          <h4>Çıkış yap</h4>
          <p>Güvenli çıkış yapmak için Evet'e tıklayın.</p>
        </div>
        <div class="modal-footer">
          <a href="javascript:void(0)" class="modal-close btn waves-effect waves-light">Geri dön</a>
          <a href="logoff" class="btn waves-effect red waves-light">Evet<i class="material-icons right">exit_to_app</i></a>
        </div>
      </div>

      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
        var options;
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, options);
        });
        document.addEventListener('DOMContentLoaded', function() {
          var options;
          var elems = document.querySelectorAll('.modal');
          var instances = M.Modal.init(elems, options);
        });
      </script>
    </body>
  </html>
