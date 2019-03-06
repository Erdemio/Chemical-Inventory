<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);

$active = "insert";
$page = "Kimyasal Ekle";
$link = "insert";

//Sabit, değiştirme.
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

      <div class="row">
        <form class="insert_form" action="a.php" method="get">
          <div class="col m12 s12 l8">
            <div class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">label_outline</i>
                  <input type="text" id="autocomplete-input-ka" class="autocomplete">
                  <label for="autocomplete-input-ka">Kimyasal Adı</label>
                </div>
              </div>
            </div>

            <div class="col s12">
              <div class="row">
                <div class="input-field col s9">
                  <i class="material-icons prefix">label_important_outline</i>
                  <input type="text" name="formula" id="autocomplete-input-kf" value="Cl&#8321; &#8322;">
                  <label for="autocomplete-input-kf">Kimyasal Formülü</label>
                </div>
                <div class="input-field col s3">
                    <button class="btn waves-effect waves-light col s5" type="submit" name="action">
                      <i class="material-icons">text_format</i> <i class="material-icons">arrow_upward</i>
                    </button>
                    <button class="btn waves-effect waves-light col s5 offset-s1" type="submit" name="action">
                      <i class="material-icons">text_format</i> <i class="material-icons">arrow_downward</i>
                    </button>
                </div>
              </div>
            </div>

            <div class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">build_outline</i>
                  <input type="text" id="autocomplete-input-uf" class="autocomplete">
                  <label for="autocomplete-input-uf">Üretici Firma</label>
                </div>
              </div>
            </div>
            <div class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">exposure_outline</i>
                  <input type="text" id="autocomplete-input-mk">
                  <label for="autocomplete-input-mk">Miktar</label>
                </div>
              </div>
            </div>
            <div class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">exposure_outline</i>
                  <input type="text" id="autocomplete-input-ad">
                  <label for="autocomplete-input-ad">Adet</label>
                </div>
              </div>
            </div>
            <div class="col s12">
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">date_range</i>
                  <input type="text" class="datepicker" id="autocomplete-input-gt">
                  <label for="autocomplete-input-gt">Giriş Tarihi</label>
                </div>
              </div>
            </div>
          </div>
        </form>
        <div class="col m12 s12 l4">
            card koy buraya
            çıktılar burada olsun
        </div>
      </div>





      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
      <script type="text/javascript">
      $(document).ready(function(){
        $('input.autocomplete#autocomplete-input-ka').autocomplete({
          data: {
            "Alizarin Sarısı": null,
            "Test": null
          },
        });
        $('input.autocomplete#autocomplete-input-uf').autocomplete({
          data: {
            "Merch": null,
            "Sigma": null
          },
        });
      });

      </script>
    </body>
  </html>
