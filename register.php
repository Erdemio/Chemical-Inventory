<?php
require_once "db.php";
require_once "class.php";
// KAYIT SAYFASI AÇ
$q = new db_query ();
$database = new database ();

        $id = "suat.ucar@deu.edu.tr";
        $pw = "123";
        $time = time();
        $q -> register($id,$pw,$time);

        echo mysql_error();

?>
