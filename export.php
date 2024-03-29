<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);

$active = "export";
$page = "Verileri Dışarıya Aktar";
$link = "export";

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
          <div class="col s12">
            <div class="card card-wns">
              <div class="card-content">
                <div class="row">
                  <div class="col s12">
                    <!--başlangıç-->
                    <form class="col s12" id="export_form" method="post" action="export_excell">

                      <div class="export_items">
                        <h5>İstenen kolon bilgileri</h5>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi[name]" value="1" class="filled-in" />
                                <span>Kimyasal Adı</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi[formula]" value="1" class="filled-in" />
                                <span>Kimyasal Formülü</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi[manufacturer]" value="1" class="filled-in" />
                                <span>Üretici Firma</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi[quantity]" value="1" class="filled-in" />
                                <span>Miktar</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi[stock]" value="1" class="filled-in" />
                                <span>Stok Adeti</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi[entry_date]" value="1" class="filled-in" />
                                <span>Stok Tarihi</span>
                              </label>
                            </div>
                          </div>
                          <!-- export bitiş -->
                      </div>
                      <div class="row">
                        <div class="input-field col s4">
                          <select name="stok_tipi[]" multiple>
                            <option value="" disabled>Seçiniz</option>
                            <option value="var" selected>Stokta olanlar</option>
                            <option value="yok" selected>Stokta olmayanlar</option>
                            <option value="tarih" selected>Raf ömrü olanlar</option>
                          </select>
                          <label>Dışa aktarılması istenen veriler</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s4">
                          <div class="input-field col s6">
                            <input type="text" class="datepicker" id="baslangic" autocomplete="off" name="bt1" data-length="10">
                            <label for="baslangic" class="truncate">Başlangıç<label>
                          </div>
                          <div class="input-field col s6">
                            <input type="text" class="datepicker" id="bitis" autocomplete="off" name="bt2" data-length="10">
                            <label for="bitis" class="truncate">Bitiş<label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                          <input type="hidden" name="action" value="export_form">
                        <button class="btn waves-effect waves-light blue darken-1" type="submit" id="gonder-export" name="action">Dışa Aktar
                          <i class="material-icons right">cloud_upload</i>
                        </button>
                        </div>
                      </div>
                    </form>
                    <!--bitiş-->
                  </div>
                </div>
              <div>
            </div>
          </div>
        </div>

      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
      <script type="text/javascript">
      <?php
        if ($_GET) {
          if ($_GET['error']=="type1") {
            $hata = "Lütfen en az 1 adet kolon seçiniz ve<br> stok tipini boş bırakmayınız.<br>Ardından tarihleri doğru seçiniz.";
          }

       echo "var error='".$hata."';";
       ?>
          M.toast({
            html: '<span class="white-text">'+error+'</span>',
            classes: "red lighten-1"
          });

          <?php } ?>

      </script>
    </body>
  </html>
