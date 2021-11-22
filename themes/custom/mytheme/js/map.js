
jQuery(function($) {
$(document).ready(function(){
	console.log('map');
	function initMap() {
	  var map = new google.maps.Map(document.getElementById("map"), {
	    center: { lat: -34.397, lng: 150.644 },
        scrollwhell: false,
	    zoom: 8,
	  });
	}
   });

});


