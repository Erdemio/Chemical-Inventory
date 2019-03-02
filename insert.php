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
          <div class="col s12">
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">textsms</i>
                <input type="text" id="autocomplete-input" class="autocomplete">
                <label for="autocomplete-input">Kimyasal Adı</label>
              </div>
            </div>
          </div>
        </div>


      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
      <script type="text/javascript">
      $(document).ready(function(){
        $('input.autocomplete').autocomplete({
          data: {
            "Apple": null,
            "Microsoft": null,
            "Google": 'https://placehold.it/250x250'
          },
        });
      });

      </script>
    </body>
  </html>
