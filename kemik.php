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
      <?php echo "Auth:".@$_SESSION['auth']."<a href='logoff'>[LOGOFF]</a>"; ?>
        some changes

      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <!--ozel script-->
    </body>
  </html>
