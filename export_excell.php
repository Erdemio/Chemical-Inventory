<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();

if (isset($_POST['action'])) {

  if (isset($_POST['kolon_adi']) && isset($_POST['stok_tipi'])) {
    header('Content-Encoding: UTF-8');
    header('Content-Type: text/plain; charset=utf-8');
    header("Content-disposition: attachment; filename=GuncelVeriler.xls");
    date_default_timezone_set('Europe/Istanbul');
    echo "\xEF\xBB\xBF";
    $post = $q -> export_form_items(@$_POST['stok_tipi'],@$_POST['kolon_adi'],@$_SESSION['auth']);

  }else{
    header("location:export?error=type1");
  }
}else{
  echo "<table><tr><td>Hata</td></tr></table>";
}
?>
