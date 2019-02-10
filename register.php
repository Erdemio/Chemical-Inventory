<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();

        $id = $_GET['id'];
        $pw = $_GET['pw'];
        $time = time();
        $q -> register($id,$pw,$time);

?>