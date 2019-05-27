<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);
//Sabit, değiştirme.
$active = "settings";
$page = "Hesap ayarları";
$link = "settings";
?>
<!DOCTYPE html>
  <html>
    <head>
      <?php require_once "header.php"; ?>
      <title><?php echo $page; ?></title>
    </head>
    <body>
      <?php require_once "headerbar.php"; ?>
      <main>
        <form class="update_password" id="reset_form" method="post">
        <div class="row">
          <div class="col s12">
            <div class="card card-wns">
                <div class="card-content">
                  <div class="row">
                    <div class="col m12 s12 l12">
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">fingerprint</i>
                            <input type="password" id="password1" class="autocomplete" autocomplete="off" name="password1">
                            <label for="password1">Şifre girmek için tıklayın</label>
                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">sync</i>
                            <input type="password" id="password2" class="autocomplete" autocomplete="off" name="password2">
                            <label for="password2">Tekrar şifre girmek için tıklayın</label>
                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <input type="hidden" name="action" value="update_password">
                        <button class="btn waves-effect right waves-light blue darken-1" type="button" id="gonder-reset">Şifremi değiştir
                          <i class="material-icons right">send</i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          </form>
      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
      <script type="text/javascript">
      $("#gonder-reset").click(function() {resetForm();});
      function resetForm(event){
        var values = $("#reset_form").serialize();
        $.ajax({
          url: "ajax.php",
          type: "post",
          data: values,
          success: function(response) {
            var error='Hata!';
            var color_class='red lighten-1';

            if (response=="4") {
              error="Şifreler aynı değil.";

            }else if (response=="1") {
              error="İllegal deneme.";

            }else if (response=="2") {
              error="Kullanıcı bulunamadı.";

            }else if (response=="3") {
              error="Şifreniz değiştirildi.";
              color_class='green lighten-1';
            }else if(response=="5"){
              error="Şifreniz değiştiremedik.";
            }else if(response=="6"){
              error="Şifreniz en az 8 karakter olmalı.";
            }

            console.log(response);


              M.toast({
                html: '<span class="white-text">'+error+'</span>',
                classes: color_class
              })
            //console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });
      }
      </script>
    </body>
  </html>
