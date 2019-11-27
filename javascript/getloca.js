$(document).ready(function(){
    if ( $('input[name=geoloc]').attr('value') == "")
    {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                success, 
                forceloca, 
                {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
                });
        } else { 
            forceloca();
        }
    }
    $( "#localisation" ).click(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                success, 
                forceloca, 
                {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
                });
        } else { 
            forceloca();
        }
      });
});


function success(pos) {
    var crd = pos.coords;
    var coords = crd.latitude + "," + crd.longitude;
    $('input[name=geoloc]').val(coords);
  }

function forceloca()
{
	$.ajax({
		url: "https://geolocation-db.com/jsonp",
		jsonpCallback: "callback",
		dataType: "jsonp",
		success: function(location) {
            var coords = location.latitude + "," + location.longitude;
            $('input[name=geoloc]').val(coords);
		}
	});	
}