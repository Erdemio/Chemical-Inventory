<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
/*

$_SESSION['user']="";*/
$_SESSION['auth']="0";
session_destroy();
header("location:login");
?>