<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
?>
<!DOCTYPE html>
  <html>
    <head>
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link type="text/css" rel="stylesheet" href="css/custom.css"  media="screen,projection"/>
      <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
      <link rel="icon" href="assets/favicon.ico" type="image/x-icon"/>
      <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
      <meta http-equiv="content-language" content="tr">
      <title>Anasayfa</title>
    </head>
    <body>
      <header>
        <nav>
          <div class="nav-wrapper">
            <div class="row">
              <div class="col m6 hide-on-med-and-down">
                <a href="index" class="breadcrumb">Anasayfa</a>
                <a href="index" class="breadcrumb">Kimyasal Listele</a>
              </div>
              <div class="col m6 s12">
                <a href="#" data-target="nav-mobile" class=" sidenav-trigger full hide-on-large-only"><i class="material-icons">menu</i></a>
                <a  href="#logoff" class="right modal-trigger"><i class="material-icons">exit_to_app</i></a>
              </div>
            </div>
          </div>
        </nav>
        <ul id="nav-mobile" class="sidenav sidenav-fixed">
          <li><div class="user-view">
            <a href="index"><img class="profil" src="assets/deu.png"></a>
            <span class="userid"><?php echo @$_SESSION['user']; ?></span>
          </div></li>
          <li class="active"><a href="#!" class="waves-effect"><i class="material-icons">view_list</i>Kimyasal Listele</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">mode_edit</i>Kimyasal Düzenle</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">add</i>Kimyasal Ekle</a></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">import_export</i>Dışarı Aktar</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#!" class="waves-effect"><i class="material-icons">info</i>Daha fazla</a></li>
          <li><div class="divider"></div></li>
          <li><a href="#logoff" class="waves-effect modal-trigger"><i class="material-icons">exit_to_app</i>Çıkış Yap</a></li>
        </ul>
      </header>
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
                          <a class="btn grey darken-1 waves-effect waves-light" id="gonder">Arama Yap <i class="material-icons right">search</i></a>
                        </div>
                       </div>
                   </form>
                 </div>
               </div>
           </div>
        </div>
      </main>
      <div id="logoff" class="modal mlogoff">
        <div class="modal-content">
          <h4>Çıkış yap</h4>
          <p>Güvenli çıkış yapmak için Evet'e tıklayın.</p>
        </div>
        <div class="modal-footer">
          <a href="javascript:void(0)" class="modal-close btn waves-effect waves-light">Geri dön</a>
          <a href="logoff" class="btn waves-effect red waves-light">Evet<i class="material-icons right">exit_to_app</i></a>
        </div>
      </div>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
        var options;
        var elems = document.querySelectorAll('.sidenav');
        var instances = M.Sidenav.init(elems, options);
        });
        document.addEventListener('DOMContentLoaded', function() {
          var options;
          var elems = document.querySelectorAll('.modal');
          var instances = M.Modal.init(elems, options);
        });
        document.addEventListener('DOMContentLoaded', function() {
          var options;
          var elems = document.querySelectorAll('select');
          var instances = M.FormSelect.init(elems, options);
        });
      </script>
      <script>
          $("#gonder").click(function() {
              var values = $("#form").serialize();
              $.ajax({
                  url: "ajax.php",
                  type: "post",
                  data: values ,
                  success: function (response) {
                      if (response=='level-error') {
                          M.toast({html: '<span onclick="toast.dismiss();" class="white-text">Arama yetkiniz yok.</span>', classes: 'red lighten-1'})
                      }else if(response=='not-found'){
                          M.toast({html: '<span class="white-text">Aradığınız kriterlere uygun veri blunamadı.</span>', classes: 'red lighten-1'})
                      }else if(response=='empty-data'){
                          M.toast({html: '<span class="white-text">Lütfen boş veri bıkrakmayınız.</span>', classes: 'red lighten-1'})
                      }else{
                        //satır eklesin hatalı giriş yaptığına dağir
                        M.toast({html: 'Arama başarılı!', classes: 'green lighten-1'});
                        $("tbody").empty();
                        $('tbody').append(response);
                      }
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      console.log(textStatus, errorThrown);
                  }
              });
          });
          $(document).on('click', '#toast-container .toast', function() {
              $(this).fadeOut(function(){
                  $(this).remove();
              });
          });
      </script>
    </body>
  </html>
