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
            <ul class="right hide-on-med-and-down">
              <li><a href="sass.html"><i class="material-icons">search</i></a></li>
              <li><a href="badges.html"><i class="material-icons">view_module</i></a></li>
              <li><a href="collapsible.html"><i class="material-icons">refresh</i></a></li>
              <li><a href="logoff"><i class="material-icons">exit_to_app</i></a></li>
            </ul>
            <a href="#" data-target="nav-mobile" class=" sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
          </div>
        </nav>

        <ul id="nav-mobile" class="sidenav  sidenav-fixed">
          <li><div class="user-view">
            <a href="index"><img class="profil" src="assets/deu.png"></a>
            <span class="userid"><?php echo @$_SESSION['user']; ?></span>
          </div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>1</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>2</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>3</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>4</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>5</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">cloud</i>6</a></li>
          <li><a href="logoff" class="waves-effect"><i class="material-icons">exit_to_app</i>Çıkış Yap</a></li>
        </ul>
      </header>

      <main>
        <div class="container">
          <div class="row">
            <div class="col m12">
              Merhaba.
            </div>
          </div>
        </div>
      </main>

      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
          var options;
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, options);
        });
      </script>
    </body>
  </html>
