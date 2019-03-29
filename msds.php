<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";

  $id = @$_GET['id'];
  if ($_GET) {

      if ($q -> get_msds($id)) {
        header("Content-type:application/pdf");
      }else{
        header("location:edit.php?error=msds-not-found&id=$id");
      }
  }else{
    echo "404.";
  }

 ?>
