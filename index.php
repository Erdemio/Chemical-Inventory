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


//Sabit, değiştirme.
?>
<!DOCTYPE html>
  <html lang="tr">
    <head>
      <?php require_once "header.php"; ?>
      <title><?php echo $page; ?></title>
    </head>
    <body>
      <?php require_once "headerbar.php"; ?>
      <main>
        <div class="row">
          <?php
          if($q -> get_data($_SESSION['auth'],"normal")){
           ?>


           <div id="sidebar" class="col m12 s12 l3">
             <div class="card card-wns">
                 <div class="card-content ">
                   <span class="card-title large">Arama Yap</span>
                   <form id="form" method="POST">
                       <div class="row search-row-side">
                         <div class="input-field col s12">
                           <i class="material-icons prefix">filter_1</i>
                          <select name="canon" id="search-select">
                            <option value="" disabled selected>Arama kriteri seçin</option>
                            <option value="k">Kimyasal Adı</option>
                            <option value="f">Üretici Firma</option>
                          </select>
                        </div>
                        <div class="input-field col s12">
                          <i class="material-icons prefix">filter_2</i>
                          <input type="hidden" value="search_form" name="action">
                          <input type="hidden" value="index" name="page">
                          <input id="search-box" type="text" name="search">
                          <label for="search-box">Kimyasal adi, üretici firma.</label>
                        </div>
                       </div>
                   </form>
                 </div>
                 <div class="card-action">
                   <a class="btn s12 grey darken-1 waves-effect waves-light disabled" id="geri-arama"><i class="material-icons">arrow_back</i></a>
                   <a class="btn s12 grey darken-1 waves-effect waves-light" id="gonder-arama">Arama Yap <i class="material-icons right">search</i></a>
                 </div>
               </div>
           </div>
         <?php } ?>
        </div>
        <div class="fixed-action-btn-for-scroll">
          <a class="btn-large scroll-to-top hide-on-med-and-down">
            <i class="large material-icons">arrow_upward</i>
          </a>
        </div>
      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
    </body>
  </html>
