<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();

        $id = "arslan.erdem@ogr.deu.edu.tr";
        $pw = "123";
        $time = time();
        $q -> register($id,$pw,$time);

        echo mysql_error();

?>
