<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);
//Sabit, değiştirme.
?>
<!DOCTYPE html>
  <html>
    <head>
      <?php require_once "header.php"; ?>
      <title>Anasayfa</title>
    </head>
    <body>
      <?php require_once "headerbar.php"; ?>
      <main>
        
      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
    </body>
  </html>
