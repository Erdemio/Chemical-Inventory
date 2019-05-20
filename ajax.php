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
       $pg = @$_POST['page'];
       $get = $q -> get_data_with_parameters($p1,$p2,$_SESSION['auth'],$pg);
      if($get=="level-error"){
        echo "level-error";
      }else if($get=="not-found"){
        echo "not-found";
      }else if($get=="empty-data"){
        echo "empty-data";
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
      $m = $m . " " . $m_type;

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
           if ($let == "101") {
             header("location:form_msds.php?error=eklendi");
           }

        }else{
          header("location:form_msds.php?error=dosya&data="+$name);
        }


    }else if (@$_POST['action']=="update_form") {
      $id = @$_POST['id'];
      $ka = @$_POST['ka'];
      $formula = @$_POST['formula'];
      $uf = @$_POST['uf'];
      $m = @$_POST['m'];
      $a = @$_POST['a'];
      $gt = @$_POST['gt'];

      if(isset($id) && !isset($ka)){
        $get = $q -> chemical_delete($id,@$_SESSION['auth']);
        echo $get;
      }else if ($ka == "" || $ka == " ") {
        echo "1";
      }else if ($formula == "" || $formula == " ") {
        echo "2";
      }else if ($uf == "" || $uf == " ") {
        echo "3";
      }else if ($m == "" || $m == " " || $m<1) {
        echo "4";
      }else if ($a == "" || $a == " " || $a<0) {
        echo "5";
      }else if ($gt == "" || $gt == " ") {
        echo "6";
      }else if ($id == "" || $id == " ") {
        echo "7";
      }else{
        $get = $q -> update_chemical($id,$ka,$formula,$uf,$m,$a,$gt,@$_SESSION['auth'],@$msds);
      }
    }else if(@$_POST['action']=="update_msds"){
      $name = $_POST['msds_n_name'];
      $file = $_FILES['file'];

      if ($file['type']=='application/pdf') {
         $let = $q -> update_msds($name,$file,@$_SESSION['auth']);
         if ($let == "101") {
           header("location:form_msds_update.php?error=eklendi&data2=$name");
         }
      }else{
        header("location:form_msds_update.php?error=dosya&data2="+$name);
      }

    }else if (@$_POST['action']=="getdatali") {
        $get = $q -> get_data_li(@$_POST['cname'],@$_SESSION['auth'],@$_POST['page']);

    }else if (@$_POST['action']=="update_password") {
        $pw1 = $_POST['password1'];
        $pw2 = $_POST['password2'];

        if (($pw1 == $pw2)) {
          if (strlen($pw1)>8) {
            $get = $q -> reset_password($pw1,@$_SESSION['auth']);
            if ($get == "1") {
              echo "1";
            }else if ($get == "2") {
              echo "2";
            }else if ($get == "3") {
              echo "3";
            }
          }else{
            echo "6";
          }

        }else{
          echo "4";
        }

    }else{
      echo "boş post";
    }

  }

?>
