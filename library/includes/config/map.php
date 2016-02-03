<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEcWVApPJQzmpgcHrQrplA7OiGbXIbKls&amp;sensor=false"></script>

<script type="text/javascript">

	var map;
	var point = new google.maps.LatLng(47.8071383, -122.3781275);

	var MY_MAPTYPE_ID = 'styled';

	function initialize() {

		var stylez = [/*
  {
    "featureType": "water",
    "stylers": [
      { "color": "#372f29" }
    ]
  },{
    "featureType": "transit",
    "stylers": [
      { "lightness": -68 },
      { "hue": "#ffc300" },
      { "saturation": -81 }
    ]
  },{
    "stylers": [
      { "visibility": "simplified" }
    ]
  },{
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      { "color": "#605d5d" }
    ]
  },{
    "featureType": "road",
    "elementType": "labels",
    "stylers": [
      { "saturation": -100 },
      { "gamma": 2.11 },
      { "lightness": -17 }
    ]
  },{
    "featureType": "poi",
    "stylers": [
      { "saturation": -100 },
      { "lightness": -46 }
    ]
  },{
    "featureType": "landscape",
    "stylers": [
      { "color": "#84807c" }
    ]
  },{
    "featureType": "poi"  },{
  }
*/]

		var mapOptions = {
			zoom: 15,
			center: point,
			panControl: false,
			zoomControl: false,
			mapTypeControl: false,
			scaleControl: false,
			streetViewControl: false,
			overviewMapControl: false,
			scrollwheel: false,

			//{
			//  mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
			//},
			mapTypeId: MY_MAPTYPE_ID
		};

		map = new google.maps.Map(document.getElementById('map_canvas'),
			mapOptions);

		var styledMapOptions = {
			name: 'Styled'
		};
		var iconBase = '/Media/Images/Icons/';
		var marker = new google.maps.Marker({
			position: point,
			map: map
		});

		var styledMapType = new google.maps.StyledMapType(stylez, styledMapOptions);

		map.mapTypes.set(MY_MAPTYPE_ID, styledMapType);
	}

	$(document).ready(function () {
		initialize();
	});
</script>
