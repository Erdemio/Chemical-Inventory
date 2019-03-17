<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";

  $id = @$_GET['id'];
  if ($_GET) {
      header("Content-type:application/pdf");
      $q -> get_msds($id);
  }else{
    echo "404.";
  }


 ?>
