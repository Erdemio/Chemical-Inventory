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
      $a = $_POST['a'];//-
      $gt = $_POST['gt'];//-

      $get = $q -> insert_chemical($ka,$formula,$uf,$m,$a,$gt,@$_SESSION['auth']);

    }

  }

?>
