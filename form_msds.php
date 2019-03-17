<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);

$active = "index";
$page = "Kimyasal Listele";
$link = "index";
?>
<!DOCTYPE html>
  <html>
    <head>
      <?php require_once "header.php"; ?>
      <title>-</title>
    </head>
    <body>
      <form name="insert_msds" action="ajax.php" enctype="multipart/form-data" method="post">
      <div class="card card-wns">
        <div class="card-content">
          <div class="row">
            <label for="file">Malzeme Güvenlik Bilgi Formu</label>
            <div class="file-field input-field">
              <div class="btn">
                <span>Dosya Seç</span>
                <input type="file" name="file" id="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path" name="msds" type="text" value="Lütfen mgbf yükleyiniz.">
                <input type="hidden" name="action" value="insert_msds">
                <input type="hidden" name="msds_n_name"
                <?php if(@$_GET){
                  echo "value=\"".@$_GET['data']."\"";
                  }
                  ?>
                >
              </div>
            </div>
          </div>
          <div class="row">
            <blockquote>
              <span class="text" id="response"><?php
              if(@$_GET){if(@$_GET['error']=="dosya"){
                 echo "Geçersiz dosya türü seçtiniz. Lütfen pdf seçiniz.";
              }}
                 ?></span>
            </blockquote>
            <button class="btn waves-effect waves-light right" type="submit">Yükle
              <i class="material-icons right">cloud_upload</i>
            </button>
          </div>
        </div>
      </div>
      </form>
      <?php require_once "scripts.php"; ?>
    </body>
  </html>
