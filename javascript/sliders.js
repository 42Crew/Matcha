$(document).ready(function(){
    $("#slider-age").slider({
      range: true,
      min: 18,
      max: 100,
      values: [ 18, 100 ],
      slide: function( event, ui ) {
        $("#agevalues").val(ui.values);
        display();
        $( "#age" ).val(ui.values[0] + " ans - " + ui.values[1] + " ans");
      }
    });

    $("#slider-localisation").slider({
        range: true,
        min: 0,
        max: $('input[name=maxdistance]').val(),
        values: [ 0, $('input[name=maxdistance]').val() ],
        slide: function( event, ui ) {
          $("#locavalues").val(ui.values);
          display();
          $( "#localisation" ).val(ui.values[0] + " km - " + ui.values[1] + " km");
        }
      });

      $("#slider-popularite").slider({
        range: true,
        min: 0,
        max: $('input[name=popularite]').val(),
        values: [ 0, $('input[name=popularite]').val() ],
        slide: function( event, ui ) {
          $("#popvalues").val(ui.values);
          display();
          $( "#popularite" ).val(ui.values[0] + " points - " + ui.values[1] + " points");
        }
      });


      $( ".mytag" ).click(function() {
        $(this).hasClass("selected") ? $(this).removeClass("selected") : $(this).addClass( "selected" );
        display();
      });
});



function display()
{
  var sliderage = $("#agevalues").val().split(',').map(Number);
  var sliderloc = $("#locavalues").val().split(',').map(Number);
  var sliderpop = $("#popvalues").val().split(',').map(Number);

  var tab = [];
  $(".mytag").each(function() {if ($(this).hasClass("selected"))tab.push($(this).html());});

  $(".user").each(function() {
    var age = $(this).children('input[name=age]').val();
    var distance = $(this).children('input[name=distance]').val();
    var popularite = $(this).children('input[name=popularite]').val();
    var matchtag = [];
    var affichage = true;

    $('.matchtag', this).each(function() {matchtag.push($(this).html());});

    for (var i = 0; i < tab.length; i++) {
      if (matchtag.includes(tab[i]) == false) affichage = false;
    }
    if ((age >= sliderage[0] && age <= sliderage[1]) 
        && (Math.round(distance) >= sliderloc[0] && Math.round(distance) <= sliderloc[1])
        && (popularite >= sliderpop[0] && popularite <= sliderpop[1]) && affichage == true)
        $(this).css('display', 'block');
    else
        $(this).css('display', 'none');
  });
}