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
        <form class="update_password" id="insert_form" method="post">
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
                    </div>
                  </div>
                </div>
            </div>

          <div class="col m12 s12 l3 right">
            <div class="card card-wns">
              <div class="card-action">
                <input type="hidden" name="action" value="update_password">
                <button class="btn waves-effect waves-light" type="button" id="gonder-insert">Şifremi değiştir
                  <i class="material-icons right">send</i>
                </button>
              </div>
            </div>
          </div>
  </div>
          </form>
      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
    </body>
  </html>
