<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);
//Sabit, değiştirme.
?>
<!DOCTYPE html>
  <html>
    <head>
      <?php require_once "header.php"; ?>
      <title>Anasayfa</title>
    </head>
    <body>
      <?php require_once "headerbar.php"; ?>
      <main>
        <div class="row">
          <?php
          $q -> get_data($_SESSION['auth']);
           ?>
           <div id="sidebar" class="col m3 s12">
             <div class="card search-menu">
                 <div class="card-content ">
                   <span class="card-title large">Arama Yap</span>
                   <form id="form" method="POST">
                       <div class="row search-row-side">
                         <div class="input-field col s12">
                           <i class="material-icons prefix">filter_1</i>
                          <select name="canon">
                            <option value="" disabled selected>Arama kriteri seçin</option>
                            <option value="k">Kimyasal Adı</option>
                            <option value="f">Üretici Firma</option>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          <i class="material-icons prefix">filter_2</i>
                          <input id="icon_prefix" type="text" name="search">
                          <label for="icon_prefix">Kimyasal adi, üretici firma.</label>
                        </div>
                        <div class="input-field col s12">
                          <input type="hidden" value="search_form" name="action">
                          <a class="btn grey darken-1 waves-effect waves-light" id="gonder-arama">Arama Yap <i class="material-icons right">search</i></a>
                        </div>
                       </div>
                   </form>
                 </div>
               </div>
           </div>
        </div>
      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
    </body>
  </html>
