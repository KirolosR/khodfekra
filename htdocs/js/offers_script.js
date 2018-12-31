var map;
var myCenter=new google.maps.LatLng(29.59493454965144,31.3330078125);
  var markers = [];
  var lat ;
  var lon ;
function initialize()
{
var mapProp = {
  center:myCenter,
  zoom:8,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

  google.maps.event.addListener(map, 'click', function(event) {
	lat = event.latLng.A ;
	lon = event.latLng.F;
	setAllMap(null);
	placeMarker(event.latLng);
	post("show_offers.php",{"lon":lon,"lat":lat}) ;
  });
}

function placeMarker(location) {

  var marker = new google.maps.Marker({
	position: location,
	map: map,
	});

 // infowindow.open(map,marker);
  markers.push(marker);
}

google.maps.event.addDomListener(window, 'load', initialize);

function setAllMap(map) {
  for (var i = 0; i < markers.length; i++) {
	markers[i].setMap(map);
  }
}

function post(path, params, method) {
	method = method || "post"; // Set method to post by default if not specified.

	// The rest of this code assumes you are not using a library.
	// It can be made less wordy if you use one.
	var form = document.getElementById("form");


	for(var key in params) {
		if(params.hasOwnProperty(key)) {
			var hiddenField = document.createElement("input");
			hiddenField.setAttribute("type", "hidden");
			hiddenField.setAttribute("name", key);
			hiddenField.setAttribute("value", params[key]);

			form.appendChild(hiddenField);
		 }
	}
}

/////////////////////////////
function showVal (newVal){
	document.getElementById("val").innerHTML=newVal;
}