  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <title>Google Maps Multiple Markers</title> 
  <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
  <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.1.min.js"></script>
  <div id="map" align="right" style="width: 580px; height: 400px;"></div>

  <script type="text/javascript">
   
    // Setup the different icons and shadows
    var iconURLPrefix = 'http://maps.google.com/mapfiles/ms/icons/';
    
    var icons = [
      iconURLPrefix + 'red-dot.png', 			//temp
      iconURLPrefix + 'green-dot.png',			//humid
      iconURLPrefix + 'blue-dot.png',			//rain
      iconURLPrefix + 'orange-dot.png',
      iconURLPrefix + 'purple-dot.png',			//wind
      iconURLPrefix + 'pink-dot.png',      
      iconURLPrefix + 'yellow-dot.png'		   	//light	
    ]
    var icons_length = icons.length;
    
    
    var shadow = {
      anchor: new google.maps.Point(15,33),
      url: iconURLPrefix + 'msmarker.shadow.png'
    };

    var map;

    var infowindow = new google.maps.InfoWindow({
      maxWidth: 160
    });
    
	var marker;
    var markers = new Array();
    var iconCounter = 0;
	
    function centerOn(location)
    {
    	if(location[1]==22.6833)
    		map.setZoom(1);
    	else
    		map.setZoom(8);
    	map.setCenter(new google.maps.LatLng(location[1], location[2]));
    }
    
    function AutoCenter(markers) 
    {
    	//  Create a new viewpoint bound
        var bounds = new google.maps.LatLngBounds();
    	//  Go through each...
      	$.each(markers, function (index, marker) {
        	bounds.extend(marker.position);
      	});
      	//  Fit these bounds to the map
      	map.fitBounds(bounds);
      	if(markers.length==1)
      	{	
      		map.setZoom(8);
      	}
      	else if(markers.length==0)
      	{
      		map.setZoom(1);
      		map.setCenter(new google.maps.LatLng(22.6833, -12.4667));
      	}  	
    }
    
    function addMarkers(locations)
    {
        for (var i = 0; i < locations.length; i++) {  
            marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i][1], locations[i][2]),
              map: map,
              icon : icons[parseInt(locations[i][3])],
              shadow: shadow
            });

            markers.push(marker);

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
              return function() {
                infowindow.setContent(locations[i][0]);
                infowindow.open(map, marker);
              }
            })(marker, i));
            
            iconCounter++;
            // We only have a limited number of possible icon colors, so we may have to restart the counter
            if(iconCounter >= icons_length){
            	iconCounter = 0;
            }
          }
        AutoCenter(markers);
    }
    function clearMap()
    {
    	map = new google.maps.Map(document.getElementById('map'), {
    	      zoom: 6,
    	      center: new google.maps.LatLng(31.7903, -106.4233),
    	      mapTypeId: google.maps.MapTypeId.ROADMAP,
    	      mapTypeControl: false,
    	      streetViewControl: false,
    	      panControl: false,
    	      zoomControlOptions: {
    	         position: google.maps.ControlPosition.LEFT_BOTTOM
    	      }
    	    });
    }
  </script> 