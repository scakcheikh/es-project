<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="./css/design.css" type="text/css">  
    <!--script type="text/javascript" src="./js/process.js"></script-->
  </head>
  <body>

  	<div id="head"></div>
  	<div id="middle">
  		<div id="left">
    			<div class="leftItems">
    				<h3>TARGET</h3>
    				<div>
              <strong>Lat:</strong> <span id="targetLat"> </span> </br> 
              <strong>Long:</strong> <span id="targetLong"> </span>
            </div>
            
            
    			</div>
    			<div class="leftItems">
    				<h3>NEARBY PLACE</h3>
    				<div id="nearbyplace"> "Winter, 2 street Bvd"</div>
    			</div>
    			<div class="leftItems">
    				<h3>TIME</h3>
    				<div id="time"></div>
    			</div>

    			<!--div class="leftItems">
            <h3>Load Kml file</h3>
    				<form action="./upload.php" method="post" enctype="multipart/form-data">
              <input type="file" id="kmlfile" name="kmlfile">
              <input type="submit" value="Load">  
            </form>
    			</div-->
  		</div>
    	<div id="map"> </div>
      <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBO7EUCu6NN0k-wyP4di2ZXoqsQYY3p_AQ&callback=initMap" ></script>
    <script  type="text/javascript">
    //<![CDATA[
   
    var poly;
    var map;
    var infoWindow;
    var marker;
    var time;

    function initMap() {
      map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(59.8586, 17.6389),
        zoom: 15,
        mapTypeId: 'roadmap'
      });

      poly = new google.maps.Polyline({
        geodesic: true,
        strokeColor: '#FF0A00',
        strokeOpacity: 1.0,
        strokeWeight: 3
        });
      poly.setMap(map);

      infoWindow = new google.maps.InfoWindow;
      marker = new google.maps.Marker({
            position: new google.maps.LatLng(59.8586, 17.6389),
            title: '#' + 0,
            map: map
          });
      document.getElementById('targetLat').innerHTML = ""+ parseFloat(59.8586);
      document.getElementById('targetLong').innerHTML = ""+ parseFloat(17.6389);
      updatePath();
      window.setInterval(updatePath, 2000);
    }

    function updatePath(){
      downloadUrl("./fetch.php", function(data){
        var xml = data.responseXML;
        var points = xml.documentElement.getElementsByTagName("point");
        var path = poly.getPath();
        for (var i = 0; i < points.length; i++) {
          var path = poly.getPath();
          var id = points[i].getAttribute("id");
          var point = new google.maps.LatLng(
              parseFloat(points[i].getAttribute("lat")),
              parseFloat(points[i].getAttribute("long")));
          path.push(point);
          var html = "<b>" + id + "</b> <br/>";
          marker.setPosition(point);
          map.setCenter(marker.getPosition());

          bindInfoWindow(marker, map, infoWindow, html);
          document.getElementById('targetLat').innerHTML = ""+ parseFloat(points[i].getAttribute("lat"));
          document.getElementById('targetLong').innerHTML = ""+ parseFloat(points[i].getAttribute("long"));
          
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

    /*Other functions not related to the map*/
    function printTime(){
      d = new Date();
      document.getElementById("time").innerHTML =d.getHours()+":"+d.getMinutes()+":"+d.getSeconds(); 
    }
    
    window.setInterval(printTime, 900);
      //]]>
    </script>	
  	</div>
    
    
        
  </body>
</html>