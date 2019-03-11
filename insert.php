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
        <form class="insert_form" action="a.php" method="get">
      <div class="row">

          <div class="col m12 s12 l8 iomr">
            <div class="card card-wns">
                <div class="card-content ">
                  <div class="row">
                    <div class="col m12 s12 l12">
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">label_outline</i>
                            <input type="text" id="autocomplete-input-ka" class="autocomplete" name="ka">
                            <label for="autocomplete-input-ka">Kimyasal Adı</label>
                          </div>
                        </div>
                      </div>

                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s9 m8 l10">
                            <i class="material-icons prefix">label_important_outline</i>
                            <input type="text" name="formula" id="autocomplete-input-kf" name="kf">
                            <label for="autocomplete-input-kf">Kimyasal Formülü</label>
                          </div>
                          <div class="input-field col s3 m4 l2">
                            <button onclick="upItem()" class="btn waves-effect waves-light col s5" type="button" name="action">
                              <i class="material-icons">arrow_upward</i>
                            </button>
                            <button onclick="downItem()" class="btn waves-effect waves-light col s5 offset-s1" type="button" name="action">
                              <i class="material-icons">arrow_downward</i>
                            </button>
                          </div>
                        </div>
                      </div>

                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">build_outline</i>
                            <input type="text" id="autocomplete-input-uf" class="autocomplete" name="uf">
                            <label for="autocomplete-input-uf">Üretici Firma</label>
                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">exposure_outline</i>
                            <input type="text" id="autocomplete-input-mk" name="m">
                            <label for="autocomplete-input-mk">Miktar</label>
                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">exposure_outline</i>
                            <input type="text" id="autocomplete-input-ad" name="a">
                            <label for="autocomplete-input-ad">Adet</label>
                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">date_range</i>
                            <input type="text" class="datepicker" id="autocomplete-input-gt" name="gt">
                            <label for="autocomplete-input-gt">Giriş Tarihi</label>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
            </div>
          </div>
          <div class="col m12 s12 l4">
            <div class="card card-wns">
              <div class="card-content">
                <ul class="collection">
                  <li class="collection-item">Kimyasal adı: <span id="ka"></span></li>
                  <li class="collection-item">Kimyasal formülü: <span id="cf"></span></li>
                  <li class="collection-item">Üretici firma: <span id="uf"></span></li>
                  <li class="collection-item">Miktar: <span id="m"></span></li>
                  <li class="collection-item">Adet: <span id="a"></span></li>
                  <li class="collection-item">Giriş tarihi: <span id="gt"></span></li>
                </ul>
              </div>
              <div class="card-action">
                <button class="btn waves-effect waves-light" type="button" name="action">Kaydet
                  <i class="material-icons right">send</i>
                </button>
                <button class="btn waves-effect waves-light" type="reset" name="action">Sıfırla
                  <i class="material-icons right">cancel</i>
                </button>
              </div>
            </div>
          </div>
      </div>




        </form>
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

      var littleChars = ["&#8320;", "&#8321;", "&#8322;", "&#8323;", "&#8324;", "&#8325;", "&#8326;", "&#8327;", "&#8328;", "&#8329;"];
      var anormalChars = ["₀","₁","₂","₃","₄","₅","₆","₇","₈","₉"];
      var normalChars = ["0","1","2","3","4","5","6","7","8","9",];
      function downItem(){
          var stringBuilder="";
          var text = document.getElementById("autocomplete-input-kf");
          var cf = document.getElementById("cf");
          var fullt = text.value;
          for(var i=0; i<fullt.length;i++){

            if (isNaN(fullt[i])) {
              stringBuilder += fullt[i];
            }else{
              if(i>=text.selectionStart && i<text.selectionEnd && fullt[i] != " "){

                var whichNumber = fullt[i];
                var newNumber = littleChars[whichNumber];
                stringBuilder += newNumber;
              }else{
                stringBuilder += fullt[i];
              }
            }

          }
          cf.innerHTML= stringBuilder;
          text.value=cf.innerHTML;
      }

      function upItem(){
        var stringBuilder="";
        var text = document.getElementById("autocomplete-input-kf");
        var cf = document.getElementById("cf");
        var fullt = text.value;
        for(var i=0; i<fullt.length;i++){
          if (i>=text.selectionStart && i<text.selectionEnd && fullt[i] != " ") {
            var que = anormalChars.indexOf(fullt[i]);
            if (que>=0 && que <=9) {
              stringBuilder += normalChars[que];
            }else{
              stringBuilder += fullt[i];
            }
          }else{
            stringBuilder += fullt[i];
          }
        }
        cf.innerHTML= stringBuilder;
        text.value=cf.innerHTML;
      }
      </script>
    </body>
  </html>
