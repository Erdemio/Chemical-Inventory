<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
if(@$_GET['error']=="not_authorized"){
  header("location:logoff");
}else if(isset($_SESSION['auth']) && @$_SESSION['auth']!=0){
  header("location:index");
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/custom.css"  media="screen,projection"/>
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="content-language" content="tr">
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
                    <a class="btn right grey darken-1 waves-effect waves-light" id="gonder" >
                      Giriş Yap <i class="material-icons right">send</i>
                    </a>
                    </div>
                  </div>
                  <div class="col s12">
                    <blockquote>
                      <span class="text" id="response"><?php if(@$_GET){if(@$_GET['error']=="first_login"){ echo "İlk önce giriş yapın.";}} ?></span>
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
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script>
        $("#gonder").click(function() {
            var values = $("#form").serialize();
            $.ajax({
                url: "ajax.php",
                type: "post",
                data: values ,
                success: function (response) {
                    document.getElementById("response").innerHTML = response;
                    if (response=='Giriş başarılı!') {
                      setTimeout(function() {
                        window.location.href = "index";
                      }, 300);
                    }else{
                      document.getElementById("password").value = "";
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $("#password").on('input',function(e){
            document.getElementById("response").innerHTML ="";
        });
    </script>
    <script type="text/javascript">
      document.addEventListener("DOMContentLoaded", function(){
        $('.preloader')
          .delay(100)
          .fadeOut();
        });
    </script>
  </body>
</html>
