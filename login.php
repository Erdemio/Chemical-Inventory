<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
define('check_for_direct_access', TRUE);
//Üst kısım sabit, index'den farklı olarak procedure.php yok.

//Giriş kontrol kısmı giriş varsa form'a yönlendirir.
if(@$_GET['error']=="not_authorized"){
  header("location:logoff");
}else if(isset($_SESSION['auth']) && @$_SESSION['auth']!=0){
  header("location:index");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <?php require_once "header.php"; ?>
    <title>Giriş Yap</title>
  </head>
  <body>
    <div class="container">
      <div class="row login-form-s">
        <div class="col s12 l4 offset-l4">
          <div class="card">
              <div class="card-content ">
                <span class="card-title large">Giriş Yap</span>
                <div class="row">
                <form class="col s12" id="form" method="POST">
                  <div class="row">
                    <div class="input-field col s12">
                    <i class="material-icons prefix">person_outline</i>
                      <input id="identy" name="identy" type="text" autocomplete="false" <?php echo 'value="'.@$_SESSION['user'].'"'; ?>>
                      <label for="identy">Kullanıcı Adı</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field col s12">
                      <i class="material-icons prefix">chevron_right</i>
                      <input id="password" name="password" type="password" autocomplete="false">
                      <label for="password">Şifre</label>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col s12">
                      <input type="hidden" value="login_form" name="action">
                    <button class="btn right grey darken-1 waves-effect waves-light" id="gonder-login" type="button" onclick="login()" name="action">Giriş Yap
                      <i class="material-icons right">send</i>
                    </button>
                    </div>
                  </div>
                  <div class="col s12">
                    <blockquote>
                      <span class="text" id="response"><?php if(@$_GET){if(@$_GET['error']=="first_login"){
                        // echo "İlk önce giriş yapın.";
                      }}
                         ?></span>
                    </blockquote>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <div class="preloader">
      <div class="progress">
        <div class="indeterminate"></div>
      </div>
    </div>
    <?php require_once "scripts.php"; ?>
  </body>
</html>
