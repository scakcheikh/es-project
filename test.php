<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="./css/design.css" type="text/css">  
    
  </head>
  <body>

  	<div id="head"></div>
  	<div id="middle">
  		<div id="left">
    			
  		</div>
    	<div id="map"> </div>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7EUCu6NN0k-wyP4di2ZXoqsQYY3p_AQ&callback=initMap" ></script>
    <script  type="text/javascript">
    //<![CDATA[
   
    var poly;
    var map;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(47.6145, -122.3418),
        zoom: 13,
        mapTypeId: 'roadmap'
      });

      poly = new google.maps.Polyline({
        strokeColor: '#000000',
        strokeOpacity: 1.0,
        strokeWeight: 3
        });
      poly.setMap(map);

      var infoWindow = new google.maps.InfoWindow;

      downloadUrl("./fetch.php", function(data) {
        var xml = data.responseXML;
        var points = xml.documentElement.getElementsByTagName("point");
        for (var i = 0; i < points.length; i++) {
          var id = points[i].getAttribute("id");
          var point = new google.maps.LatLng(
              parseFloat(points[i].getAttribute("lat")),
              parseFloat(points[i].getAttribute("lng")));
          
          var path = poly.getPath();
          path.push(point);
          
          var html = "<b>" + id + "</b> <br/>";
          var marker = new google.maps.Marker({
            map: map,
            position: point
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

      //]]>
    </script>	
  	</div>
    
    
        
  </body>
</html>