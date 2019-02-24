/* ------------------------Sabit javascript Kısmı------------------------ */

//Preloader çalıştırır durdurur.
document.addEventListener("DOMContentLoaded", function() {
  $('.preloader')
    .delay(100)
    .fadeOut();
});
//Kenardaki barnın framework da ki tanımlaması.
document.addEventListener('DOMContentLoaded', function() {
  var options;
  var elems = document.querySelectorAll('.sidenav');
  var instances = M.Sidenav.init(elems, options);
});
//Açılır pencerenin framework da ki tanımlaması.
document.addEventListener('DOMContentLoaded', function() {
  var options;
  var elems = document.querySelectorAll('.modal');
  var instances = M.Modal.init(elems, options);
});
//Form nesnesi olan input nesnesinin frameworkda ki tanımlaması.
document.addEventListener('DOMContentLoaded', function() {
  var options;
  var elems = document.querySelectorAll('select');
  var instances = M.FormSelect.init(elems, options);
});

//################################################################
//################################################################
//################################################################
//################################################################
//################################################################

/* ------------------------jQuery Kısmı------------------------ */

//Kenarda çıkan bildirimlerin tıklatılınca kapatılmasını sağlar.
$(document).on('click', '#toast-container .toast', function() {
  $(this).fadeOut(function() {
    $(this).remove();
  });
});
//Tablo tıklama ile A-Z Z-A sıralamasını sağlar.
$('#kimyasal-liste').tablesorter({
  headers: {
    0: {
      sorter: true
    },
    1: {
      sorter: true
    },
    2: {
      sorter: true
    },
    3: {
      sorter: false
    }
  }
});
//Listeleme'nin sağlandığı formda ki işlemleri sağlar.
$("#gonder-arama").click(function() {
  var values = $("#form").serialize();
  $.ajax({
    url: "ajax.php",
    type: "post",
    data: values,
    success: function(response) {
      if (response == 'level-error') {
        M.toast({
          html: '<span onclick="toast.dismiss();" class="white-text">Arama yetkiniz yok.</span>',
          classes: 'red lighten-1'
        })
      } else if (response == 'not-found') {
        M.toast({
          html: '<span class="white-text">Aradığınız kriterlere uygun veri blunamadı.</span>',
          classes: 'red lighten-1'
        })
      } else if (response == 'empty-data') {
        M.toast({
          html: '<span class="white-text">Lütfen boş veri bıkrakmayınız.</span>',
          classes: 'red lighten-1'
        })
      } else {
        M.toast({
          html: 'Arama başarılı!',
          classes: 'green lighten-1'
        });
        $("tbody").empty();
        $('tbody').append(response);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});
//Giriş formunda ki işlemleri sağlar.
$("#gonder-login").click(function() {
  var values = $("#form").serialize();
  $.ajax({
    url: "ajax.php",
    type: "post",
    data: values,
    success: function(response) {
      document.getElementById("response").innerHTML = response;
      if (response == 'Giriş başarılı!') {
        setTimeout(function() {
          window.location.href = "index";
        }, 300);
      } else {
        document.getElementById("password").value = "";
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});
$("#password").on('input', function(e) {
  document.getElementById("response").innerHTML = "";
});

//
