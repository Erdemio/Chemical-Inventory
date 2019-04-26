<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();

if (isset($_POST['action'])) {
  
  header('Content-Encoding: UTF-8');
  header('Content-Type: text/plain; charset=utf-8');
  header("Content-disposition: attachment; filename=GuncelVeriler.xls");
  echo "\xEF\xBB\xBF";
    $q -> export_form_items(@$_POST['stok_tipi'],@$_POST['kolon_adi'],@$_SESSION['auth']);
}else{
  echo "<table><tr><td>Hata</td></tr></table>";
}


?>
