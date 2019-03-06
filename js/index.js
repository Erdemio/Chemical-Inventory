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

//Alt mesaj
document.addEventListener('DOMContentLoaded', function() {
  var options = {enterDelay:325};
  var elems = document.querySelectorAll('.tooltipped');
  var instances = M.Tooltip.init(elems, options);
});


//belki kaldırmalıyım
$(document).ready(function() {
  $('input#autocomplete-input-ka, textarea#textarea2').characterCounter();
});

//Form nesnesi olan datepicker nesnesinin frameworkda ki tanımlaması.
document.addEventListener('DOMContentLoaded', function() {
  var options = {
    format: 'dd-mm-yyyy',
    showClearBtn: true,
    firstDay: 1,
    showDaysInNextAndPreviousMonths:false,
    setDefaultDate:true,
    yearRange:2,
    i18n: {
      clear: 'Temizle',
      cancel: 'İptal',
      done: 'Tamam',
      months: [
        'Ocak',
        'Şubat',
        'Mart',
        'Nisan',
        'Mayıs',
        'Haziran',
        'Temmuz',
        'Ağustos',
        'Eylül',
        'Ekim',
        'Kasım',
        'Aralık'
      ],
      monthsShort: [
        'Ocak',
        'Şubat',
        'Mart',
        'Nisan',
        'Mayıs',
        'Haziran',
        'Temmuz',
        'Ağustos',
        'Eylül',
        'Ekim',
        'Kasım',
        'Aralık'
      ],
      weekdays: [
        'Pazar',
        'Pazartesi',
        'Salı',
        'Çarşamba',
        'Perşembe',
        'Cuma',
        'Cumartesi'
      ],
      weekdaysShort: [
        'Pazar',
        'Pazartesi',
        'Salı',
        'Çarşamba',
        'Perşembe',
        'Cuma',
        'Cumartesi'
      ],
      weekdaysAbbrev: ['P', 'P', 'S', 'Ç', 'P', 'C', 'C']

    }
  };
  var elems = document.querySelectorAll('.datepicker');
  var instances = M.Datepicker.init(elems, options);
});
/*
//Akordiyon açılır kapanır sekmenin frameworkda ki tanımlaması.
document.addEventListener('DOMContentLoaded', function() {
  var options;
  var elems = document.querySelectorAll('.collapsible');
  var instances = M.Collapsible.init(elems, options);
});*/

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
$('table').tablesort();

//Listeleme'nin sağlandığı formda ki işlemleri sağlar.
$("#gonder-arama").click(function() {
  var values = $("#form").serialize();
  $.ajax({
    url: "ajax.php",
    type: "post",
    data: values,
    success: function(response) {
      if (response == 'level-error') {
        window.location.href = "login";
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

        $("#geri-arama").removeClass("disabled");
        $("tbody tr").addClass("hide");
        $('tbody').append(response);

      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});
//Geri arama KISMINI YAPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPPP
$("#geri-arama").click(function() {
  $("tbody tr").removeClass("hide");
  $(".searched").remove();
  $("#geri-arama").addClass("disabled");

  M.toast({
    html: '<span class="white-text">Bir önceki aramaya geri dönüldü.</span>',
    classes: 'green lighten-1'
  })
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
