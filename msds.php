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

        $q = @mysql_query("SELECT unique_id,n_name FROM `kimyasal` where n_name = $id");
        if (mysql_num_rows($q)>0) {
          while ($row = mysql_fetch_assoc($q)) {
            $unique_id = $row['unique_id'];
          }
        }

        header("location:edit.php?error=msds-not-found&id=$unique_id");

      }
  }else{
    echo "404.";
  }

 ?>
