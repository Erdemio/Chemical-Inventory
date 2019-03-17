<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
//kontrol eklendiği zaman ajax hata veriyor, EKLEME.

  if ($_POST){
    if (@$_POST['action']=="login_form") {

      $identy = @$_POST['identy'];
      $password = @$_POST['password'];
      if ($identy!="" && $password!="") {
        $_SESSION['user'] = $identy;
        if($q -> login($identy,$password)){
            echo "Giriş başarılı!";
        }else{
          echo "Kullanıcı adı veya şifre yanlış.";
        }
      }else{
        echo "Kullanıcı adı veya şifreyi boş bırakmayın.";
      }
    }else if (@$_POST['action']=="search_form") {

       $p1 = @$_POST['canon'];
       $p2 = @$_POST['search'];
       $get = $q -> get_data_with_parameters($p1,$p2,$_SESSION['auth']);
      if($get=="level-error"){
        echo "level-error";
      }else if($get=="not-found"){
        echo "not-found";
      }else if($get=="empty-data"){
        echo "not-found";
      }else{
        echo $get;
      }

    }else if (@$_POST['action']=="insert_form") {

      $ka = $_POST['ka']; //+
      $formula = $_POST['formula'];//-
      $uf = $_POST['uf'];//+
      $m = $_POST['m'];//-
      $m_type = $_POST['m_type'];
      $a = $_POST['a'];//-
      $gt = $_POST['gt'];//-
      $m = $m + " " + $m_type;

      if ($ka == "" || $ka == " ") {
        echo "1";
      }else if ($formula == "" || $formula == " ") {
        echo "2";
      }else if ($uf == "" || $uf == " ") {
        echo "3";
      }else if ($m == "" || $m == " " || $m<1) {
        echo "4";
      }else if ($a == "" || $a == " " || $a<1) {
        echo "5";
      }else if ($gt == "" || $gt == " ") {
        echo "6";
      }else{
        $get = $q -> insert_chemical($ka,$formula,$uf,$m,$a,$gt,@$_SESSION['auth'],@$msds);
      }
    }else if(@$_POST['action']=="insert_msds"){
        $name = $_POST['msds_n_name'];
        $file = $_FILES['file'];

        if ($file['type']=='application/pdf') {
          $let = $q -> insert_msds($name,$file,@$_SESSION['auth']);  
        }else{
          echo "Geçersiz dosya türü.";
          header("location:form_msds.php?error=dosya&data="+$name);
        }


    }

  }

?>
