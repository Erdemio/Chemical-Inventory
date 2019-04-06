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

//Alt mesaj tooltip
document.addEventListener('DOMContentLoaded', function() {
  var options = {enterDelay:325};
  var elems = document.querySelectorAll('.tooltipped');
  var instances = M.Tooltip.init(elems, options);
});

// aksiyon butonları
/*
document.addEventListener('DOMContentLoaded', function() {
  var elems = document.querySelectorAll('.fixed-action-btn');
  var instances = M.FloatingActionButton.init(elems, {
    direction: 'left'
  });
});*/

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

//BURASI ÇALIŞMIYOR BURAYI DÜZELTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT
$("#search-select").on('change', function() {
  $( "#search-box").click();
});

document.addEventListener('DOMContentLoaded', function() {
  var options = {hover:true,constrainWidth:false,alignment:'right'};
  var elems = document.querySelectorAll('.dropdown-trigger2');
  var instances = M.Dropdown.init(elems, options);
});

function getDataLi(cName,pg){
  
  $.ajax({
    url: "ajax.php",
    type: "post",
    data: { action: "getdatali", cname: cName, page: pg },
    success: function(response) {
        document.getElementById("edit-modal-content").innerHTML=response;
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}



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

$("#geri-arama").click(function() {
  $("tbody tr").removeClass("hide");
  $(".searched").remove();
  $("#geri-arama").addClass("disabled");

  M.toast({
    html: '<span class="white-text">Bir önceki aramaya geri dönüldü.</span>',
    classes: 'green lighten-1'
  })
});



//
