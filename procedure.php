<?php
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.

$stock_count1 = $q -> stock_count("1");
$stock_count2 = $q -> stock_count("2");
if(@empty($_SESSION['auth'])){
  //header("location:login?error=first_login");
  header("location:login");
}else{
  if ($q -> check_auth(@$_SESSION['auth'])==false) {
    header("location:login?error=not_authorized");
  }
}
 ?>
