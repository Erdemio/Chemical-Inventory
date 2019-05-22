<?php
require_once "db.php";
require_once "class.php";
$q = new db_query ();
$database = new database ();
require_once "procedure.php";
define('check_for_direct_access', TRUE);

if (isset($_GET['id'])) {
  $chemical =  $q->header_tag(@$_GET['id'],$_SESSION['auth']);
  if ($chemical != "-1" && $chemical != "-2") {
    $_SESSION['last_edit']=@$_GET['id'];
  }else{
    header("location:index");
  }
}else if(isset($_SESSION['last_edit'])){
  $chemical =  $q->header_tag($_SESSION['last_edit'],$_SESSION['auth']);
}else{
  header("location:index");
}



$active = "edit";
$page = "Kimyasal Düzenle";
$link = "edit";






$chemical_name = "<a href=\"index\" class=\"breadcrumb\">".$chemical."</a>";

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

        <?php
          //form verisi get ile getirilsin.
          if ($_GET && isset($_GET['id']) && $_GET['id'] > 1 && $_GET['id'] < 999999999999999) {
            $q->update_form_data(@$_GET['id'],$_SESSION['auth']);
          }else if(isset($_SESSION['last_edit'])){
            header("location:edit.php?id=".$_SESSION['last_edit']);
          }else{
            header("location:index");
          }

        ?>
        <div class="col m12 s12 l4" id="msds_form">
          <iframe src="form_msds_update.php<?php echo "?data=".@$_GET['id']; ?>" width="100%" height="1000rem" id="insert_frame" style="border:0px"></iframe>
        </div>





      </main>
      <?php require_once "modal.php"; ?>
      <?php require_once "scripts.php"; ?>
      <script type="text/javascript">

      $("#gonder-insert").click(function() {
        editForm();
      });

      $("#gonder-sil").dblclick(function() {
        var values = $('input[name="id"]').val();
        $.ajax({
          url: "ajax.php",
          type: "post",
          data: "action=update_form&id="+values,
          success: function(response) {

            if (response=="8") {
              error = "Başarılı bir şekilde silindi.";
              var color_class='blue lighten-1';
              setTimeout(function(){ location.href="index" }, 1000);
            }else if (response=="9") {
              error = "Böyle bir kimyasal artık mevcut değil!";
              var color_class='red lighten-1';
            }else if (response=="10") {
              error = "Kimyasal bulunamadı!";
              var color_class='red lighten-1';
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
      });

      var files;
      $('input[type=file]').on('change', prepareUpload);
      function prepareUpload(event)
      {
        files = event.target.files;
      }

      function editForm(event){

        var values = $("#edit_form").serialize();

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
                error = "Adet 0'dan küçük olamaz.";
              }else if(response == "6") {
                error = "Giriş tarihini boş bırakmayın.";
              }else if(response == "7"){
                error = "Veri girişini doğru sağlayınız."
              }else if(response == "10"){
                error = "Kimyasal adı en az 1, en çok 64 karakter olabilir.";
              }else if(response == "11"){
                error = "Formül en az 1, en çok 32 karakter olabilir.";
              }else if(response == "12"){
                error = "Üretici firma en az 1, en çok 32 karakter olabilir.";
              }else if(response == "13"){
                error = "Miktar en az 1, en çok 10 adet rakam içerebilir.";
              }else if(response == "14"){
                error = "Adet en az 1, en çok 10 adet rakam içerebilir.";
              }else if(response == "15"){
                error = "Tarih gg-aa-yyyy formatında olmalıdır.";
              }else if(response == "8") {
                error = "Veriler güncellendi.";
                color_class='green lighten-1';
                setTimeout(function(){ location.reload(); }, 1000);
              }else{
                error = "Herhangi bir veri güncellenmedi."+response;
              }
              M.toast({
                html: '<span class="white-text">'+error+'</span>',
                classes: color_class
              })
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
          if (val>0) {
            val = eval(parseInt(val)-1);
          }
          document.getElementById("a").value = val;
          document.getElementById("a_span").innerHTML = val + " ";
        });



        $("#m_type_div").click(function(){
           document.getElementById("m_span").innerHTML = document.querySelector('input[name="m"]').value + " " + document.querySelector('input[name="m_type"]:checked').value;
        });


      function input2span(name){

          document.getElementById(name+"_span").innerHTML = document.getElementById(name).value;


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
