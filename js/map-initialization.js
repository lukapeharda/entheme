var map;
function initialize() {
	var mapOptions = {
	    zoom: parseInt(entheme_m.zoom),
	    center: new google.maps.LatLng(entheme_m.lat, entheme_m.lng),
	    mapTypeId: google.maps.MapTypeId.ROADMAP,
	    zoomControl: false,
	    streetViewControl: false,
	    styles: entheme_m.styles
  	};
  	map = new google.maps.Map(document.getElementById('map'), mapOptions);
  	marker = new google.maps.Marker({
  	position: map.getCenter(), 
  	map: map, 
	  	icon: {
	      path: google.maps.SymbolPath.CIRCLE,
	      scale: 10,
	      strokeColor: entheme_m.stroke_color,
	      strokeWeight: 5
	    },
	});
}
google.maps.event.addDomListener(window, 'load', initialize);