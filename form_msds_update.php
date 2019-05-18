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
      <form name="update_msds" action="ajax.php" enctype="multipart/form-data" method="post">
      <div class="card card-wns">
        <div class="card-content">
          <div class="row">
            <label for="file">Malzeme Güvenlik Bilgi Formu</label>
            <div class="file-field input-field">
              <div class="btn blue darken-1">
                <span>Dosya Seç</span>
                <input type="file" name="file" id="file">
              </div>
              <div class="file-path-wrapper">
                <input class="file-path" name="msds" type="text" value="Lütfen mgbf yükleyiniz.">
                <input type="hidden" name="action" value="update_msds">
                <input type="hidden" name="msds_n_name"
                <?php if(@$_GET){
                    if (isset($_GET['data2'])) {
                      $n = $_GET['data2'];
                    }else{
                      $n = $q->id_to_n(@$_GET['data'],$_SESSION['auth']);
                    }
                  echo "value=\"".$n."\"";
                  }
                  ?>
                >
              </div>
            </div>
          </div>
          <div class="row">
            <blockquote>
              <span class="text" id="response"><?php
              if(@$_GET){
                if(@$_GET['error']=="dosya"){
                 echo "Geçersiz dosya türü seçtiniz. Lütfen pdf seçiniz.";
               }else if(@$_GET['error']=="eklendi"){
                echo "Başarılı bir şekilde güncellediniz.";
                /*echo "<script>setTimeout(function(){ var iframes = document.querySelectorAll('body');
                      for (var i = 0; i < iframes.length; i++) {
                          iframes[i].parentNode.removeChild(iframes[i]);
                      } }, 2000);</script>";*/
               }
              }
                 ?></span>
            </blockquote>
            <button class="btn waves-effect waves-light right blue darken-1" type="submit">Güncelle
              <i class="material-icons right">cloud_upload</i>
            </button>
          </div>
        </div>
      </div>
      </form>
      <?php require_once "scripts.php"; ?>
    </body>
  </html>
