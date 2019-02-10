<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();

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
    }
  }

?>
