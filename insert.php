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
        <form class="insert_form" id="insert_form" enctype="multipart/form-data" method="post">
      <div class="row">

          <div class="col m12 s12 l8 iomr">
            <div class="card card-wns">
                <div class="card-content">
                  <div class="row">
                    <div class="col m12 s12 l12">
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">label_outline</i>
                            <input type="text" id="ka" class="autocomplete" autocomplete="off" onchange="input2span('ka')" name="ka">
                            <label for="ka">Kimyasal adı girmek için tıklayın</label>
                          </div>
                        </div>
                      </div>

                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12 m8 l10">
                            <i class="material-icons prefix">label_important_outline</i>
                            <input type="text" name="formula" autocomplete="off" id="kf" name="kf" onchange="input2span('kf')">
                            <label for="kf" class="truncate">Kimyasal formülü girmek için tıklayın</label>
                          </div>
                          <div class="input-field col s12 m4 l2">
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
                            <i class="material-icons prefix">build</i>
                            <input type="text" id="uf" class="autocomplete" name="uf" onchange="input2span('uf')">
                            <label for="uf" class="truncate">Üretici firma girmek için tıklayın</label>
                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12 l3">
                            <i class="material-icons prefix">exposure</i>
                            <input type="text" id="m" autocomplete="off" name="m" onchange="input2span('m')" value="1">
                            <label for="m" class="truncate">Miktar girmek için tıklayın</label>
                          </div>
                          <div class="input-field col s12 l9" id="m_type_div">

                            <div class="input-field col s12 m12 l2">
                              <label>
                                <input class="with-gap" name="m_type" id="m_type" type="radio" value="litre" checked />
                                <span>Litre</span>
                              </label>
                            </div>
                            <div class="input-field col s12 m12 l2">
                              <label>
                                <input class="with-gap" name="m_type" id="m_type" type="radio" value="mililitre" />
                                <span>Mililitre</span>
                              </label>
                            </div>
                            <div class="input-field col s12 m12 l2">
                              <label>
                                <input class="with-gap" name="m_type" id="m_type" type="radio" value="kilogram" />
                                <span>Kilogram</span>
                              </label>
                            </div>
                            <div class="input-field col s12 m12 l2">
                              <label>
                                <input class="with-gap" name="m_type" id="m_type" type="radio" value="gram" />
                                <span>Gram</span>
                              </label>
                            </div>
                            <div class="input-field col s12 m12 l2">
                              <label>
                                <input class="with-gap" name="m_type" id="m_type" type="radio" value="miligram" />
                                <span>Miligram</span>
                              </label>
                            </div>



                          </div>
                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12 m8 l10">
                            <i class="material-icons prefix">exposure</i>
                            <input type="text" id="a" name="a" autocomplete="off" onchange="input2span('a')" value="1">
                            <label for="a" class="truncate">Adet girmek için tıklayın</label>
                          </div>

                          <div class="input-field col s12 m4 l2">
                            <button class="btn waves-effect waves-light col s5" type="button" id="count-down">
                              <i class="material-icons">exposure_neg_1</i>
                            </button>
                            <button class="btn waves-effect waves-light col s5 offset-s1" type="button" id="count-up">
                              <i class="material-icons">exposure_plus_1</i>
                            </button>
                          </div>

                        </div>
                      </div>
                      <div class="col s12">
                        <div class="row">
                          <div class="input-field col s12">
                            <i class="material-icons prefix">date_range</i>
                            <input type="text" class="datepicker" id="gt" autocomplete="off" name="gt" onchange="input2span('gt')">
                            <label for="gt" class="truncate">Giriş tarihi seçmek için tıklayın</label>
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
                  <li class="collection-item">Kimyasal adı: <span id="ka_span"></span></li>
                  <li class="collection-item">Kimyasal formülü: <span id="kf_span"></span></li>
                  <li class="collection-item">Üretici firma: <span id="uf_span"></span></li>
                  <li class="collection-item">Miktar: <span id="m_span"></span></li>
                  <li class="collection-item">Adet: <span id="a_span"></span></li>
                  <li class="collection-item">Giriş tarihi: <span id="gt_span"></span></li>
                </ul>
              </div>
              <div class="card-action">
                <input type="hidden" name="action" value="insert_form">
                <button class="btn waves-effect waves-light" type="button" id="gonder-insert">Kaydet
                  <i class="material-icons right">send</i>
                </button>
                <button class="btn waves-effect waves-light" type="reset" id="gonder-reset">Sıfırla
                  <i class="material-icons right">cancel</i>
                </button>
              </div>
            </div>
          </div>
          </form>
          <!-- Ekleme sonucunda eğer msds yoksa açılsın -->
          <div class="col m12 s12 l4 hide" id="msds_form">
            <iframe src="form_msds.php" width="100%" height="1000rem" id="insert_frame" style="border:0px"></iframe>
          </div>





      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
      <script type="text/javascript">

      $("#gonder-insert").click(function() {
        insertForm();
      });
      var files;
      $('input[type=file]').on('change', prepareUpload);
      function prepareUpload(event)
      {
        files = event.target.files;
      }

      function insertForm(event){

        var values = $("#insert_form").serialize();

        $.ajax({
          url: "ajax.php",
          type: "post",
          data: values,
          success: function(response) {
            var error='Formu boş bırakmayınız.';
            var color_class='red lighten-1';
              if (response == "1") {
                error = "Kimyasal adını boş bırakmayınız.";
              }else if(response == "2") {
                error = "Formülü boş bırakmayınız.";
              }else if(response == "3") {
                error = "Üretici firmayı boş bırakmayınız.";
              }else if(response == "4") {
                error = "Miktar 1'den küçük olamaz.";
              }else if(response == "5") {
                error = "Adet 1'den küçük olamaz.";
              }else if(response == "6") {
                error = "Giriş tarihini boş bırakmayın.";
              }else if(response == "70"){
                error = "Ekleme işlemi başarılı.<br>MGBF bulamadım eklemek istermisin?";
                color_class='orange lighten-1';
                $("#insert_frame").attr("src", "form_msds.php?data="+document.querySelector('input[name="ka"]').value);
                $("#msds_form").removeClass( "hide" );
              }else if(response == "71"){
                error = "Ekleme işlemi başarılı.<br>MGBF zaten var.";
                color_class='green lighten-1';
              }else if(response == "8"){
                error = "Ekleme için yetkiniz yok.";
              }else if(response == "9"){
                error = "Tekrar giriş yapın.";
              }else{
                error = "Veri girişini doğru sağlayınız."
              }
              M.toast({
                html: '<span class="white-text">'+error+'</span>',
                classes: color_class
              })
            console.log(response);
          },
          error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });


      }

        $("#gonder-reset").click(function(){
          $("#msds_form").addClass( "hide" );
          $(".collection-item span").html("");
          document.getElementById("a").value=1;
        });

        $("#count-up").click(function(){
          val = document.getElementById("a").value;
          val = eval(parseInt(document.getElementById("a").value)+1);

           document.getElementById("a").value = val;
           document.getElementById("a_span").innerHTML = val + " ";
        });

        $("#count-down").click(function(){
          var val = document.getElementById("a").value;
          if (val>1) {
            val = eval(parseInt(val)-1);
          }
          document.getElementById("a").value = val;
          document.getElementById("a_span").innerHTML = val + " ";
        });



        $("#m_type_div").click(function(){
           document.getElementById("m_span").innerHTML = document.querySelector('input[name="m"]').value + " " + document.querySelector('input[name="m_type"]:checked').value;
        });


      function input2span(name){
        if (name == "m") {
            document.getElementById(name+"_span").innerHTML = document.querySelector('input[name="m"]').value + " " + document.querySelector('input[name="m_type"]:checked').value;
        }else {
          document.getElementById(name+"_span").innerHTML = document.getElementById(name).value;
        }

      }

      $(document).ready(function(){
        $('input.autocomplete#ka').autocomplete({
          data: {
            <?php
              $q -> get_autocomplete_data("chemical_names",$_SESSION['auth']);
             ?>},
        });
        $('input.autocomplete#uf').autocomplete({
          data: {
            <?php
              $q -> get_autocomplete_data("manufacturer_names",$_SESSION['auth']);
             ?>},
        });

      });

      var littleChars = ["&#8320;", "&#8321;", "&#8322;", "&#8323;", "&#8324;", "&#8325;", "&#8326;", "&#8327;", "&#8328;", "&#8329;"];
      var anormalChars = ["₀","₁","₂","₃","₄","₅","₆","₇","₈","₉"];
      var normalChars = ["0","1","2","3","4","5","6","7","8","9",];
      function downItem(){
          var stringBuilder="";
          var text = document.getElementById("kf");
          var cf = document.getElementById("kf_span");
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
        var text = document.getElementById("kf");
        var cf = document.getElementById("kf_span");
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
