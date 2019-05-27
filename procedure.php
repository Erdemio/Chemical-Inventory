<?php
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.

 $fq = $q -> stock_count();
 $stoklar = explode(" ",$fq);
$stock_count1 = $stoklar[0];
$stock_count2 = $stoklar[1];
$stock_count3 = $stoklar[2];

if(@empty($_SESSION['auth'])){
  //header("location:login?error=first_login");
  header("location:login");
}else{
  if ($q -> check_auth(@$_SESSION['auth'])==false) {
    header("location:login?error=not_authorized");
  }
}
 ?>
