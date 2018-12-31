var Site = {
	init: function(){
		this.tabs();
		this.loadMap_in();
		this.loadMap_out();
	},
	tabs: function(){
		var tabs = $('#proTabs > .tabs'),
			divs = tabs.find('div'),
				tabHeadings = tabs.prev('#tabHeadings');
		
		//initially hide all but first (make it in css) 
		//divs.not(':first').hide();
		
		//listen for click
		tabHeadings.delegate('li','click',function(e){
			var li = $(this),
				hash;
			
			//cahnge selected to selected one
			li.siblings().removeClass('selected').end().addClass('selected');
			//grap the hash
			hash = li.children('a').attr('href');
			//show the hash selected
			divs.hide().filter(hash).show();
		});
	},
	loadMap_in : function(){
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
			post("shop_reg.php",{"lon":lon,"lat":lat}) ;
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

	},
	loadMap_out : function(){
		var geocoder;
		var map;
		var infowindow = new google.maps.InfoWindow();
		var marker;
		function initialize() {
		  geocoder = new google.maps.Geocoder();
		  var latlng = new google.maps.LatLng(40.730885,30);
		  var mapOptions = {
			zoom: 8,
			center: latlng,
			mapTypeId: 'roadmap'
		  }
			codeLatLng();
		  map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);


		}

		function codeLatLng() {
		  // var input = document.getElementById('latlng').value;
		 // var latlngStr = input.split(',', 2);
		  var div1 = document.getElementById('dom-target1') ;
		  var div2 = document.getElementById('dom-target2') ;
		  var lat = parseFloat(div2.textContent);
		  var lng = parseFloat(div1.textContent);
		  var latlng = new google.maps.LatLng(lat, lng);
		  geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  if (results[1]) {
				map.setZoom(11);
				marker = new google.maps.Marker({
					position: latlng,
					map: map
				});
				infowindow.setContent(results[1].formatted_address);
				infowindow.open(map, marker);
			  } else {
				alert('No results found');
			  }
			} else {
			  alert('Geocoder failed due to: ' + status);
			}
		  });
		}

		google.maps.event.addDomListener(window, 'load', initialize);

	}
	
};

Site.init();




///////////////////////////////////////////////////////
/////////////////////////////////////////////////////////



