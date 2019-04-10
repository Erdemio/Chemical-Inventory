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
                    <form class="col s12" id="export_form" action="test.php" method="GET">

                      <div class="export_items">
                        <h5>İstenen kolon bilgileri</h5>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi['name']" class="filled-in" />
                                <span>Kimyasal Adı</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi['formula']" class="filled-in" />
                                <span>Kimyasal Formülü</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi['manufacturer']" class="filled-in" />
                                <span>Üretici Firma</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi['quantity']" class="filled-in" />
                                <span>Miktar</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi['stock']" class="filled-in" />
                                <span>Stok Adeti</span>
                              </label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s6">
                              <label>
                                <input type="checkbox" name="kolon_adi['entry_date']" class="filled-in" />
                                <span>Stok Tarihi</span>
                              </label>
                            </div>
                          </div>
                          <!-- export bitiş -->
                      </div>
                      <div class="row">
                        <div class="input-field col s4">
                          <select name="stok_tipi[]" multiple>
                            <option value="" disabled selected>Seçiniz</option>
                            <option value="var">Stokta olanlar</option>
                            <option value="yok">Stokta olmayanlar</option>
                          </select>
                          <label>Dışa aktarılması istenen veriler</label>
                        </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12">
                        <button class="btn waves-effect waves-light" type="button" name="action">Dışa Aktar
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
    </body>
  </html>
