<?php
		$var=$_GET['tipo'];
		$lat=$_GET['lat'];
		$lng=$_GET['lng'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php echo "<title>$var</title>";?>


	<link rel="stylesheet" type="text/css" href="../build/potree/potree.css">
	<link rel="stylesheet" type="text/css" href="../libs/jquery-ui-1.11.4/jquery-ui.css">
	
	
	<script type="text/javascript">
		function mostranascondi(id)
		{
 			if (document.getElementById(id).style.visibility != 'visible')
 			document.getElementById(id).style.visibility = 'visible';
 			else
 			document.getElementById(id).style.visibility = 'hidden';
		}
	</script>
	
	
  </head>

  <body>
  
	<script src="../libs/jquery-2.1.4/jquery-2.1.4.min.js"></script>
	<script src="../libs/jquery-ui-1.11.4/jquery-ui.min.js"></script>
	<script src="../libs/three.js/build/three.js"></script>
	<script src="../libs/other/stats.min.js"></script>
	<script src="../libs/other/BinaryHeap.js"></script>
	<script src="../libs/tween/tween.min.js"></script>
	<script src="../libs/d3/d3.js"></script>
	<script src="../libs/proj4/proj4.js"></script>
	<script src="../build/potree/potree.js"></script>
	<script src="../libs/plasio/js/laslaz.js"></script>
	<script src="../libs/plasio/vendor/bluebird.js"></script>
	<script src="../build/potree/laslaz.js"></script>
	<script src="http://openlayers.org/en/v3.11.2/build/ol-debug.js"></script>
	

    <div style="position: absolute; width: 100%; height: 100%; left: 0px; top: 0px; ">
	
		<div id="potree_render_area">
			
			<img class="potree_menu_toggle" src="../resources/icons/menu_button.svg" onclick="viewer.toggleSidebar()" />
			<img id="potree_map_toggle" src="../resources/icons/map_icon.png" onclick="mostranascondi('mappa')"/>
			
			
			<div id="mappa" style="position: absolute; background-color: rgb(229, 227, 223); left: 50px; top: 55px; width: 300px; height: 300px; visibility: hidden">

 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCU8lMT6cqLwbQYoYjds6yblzFEOAMPco8" type="text/javascript"></script>
 <script type="text/javascript">
		 // definisco l'oggetto che rappresenta il centro della mappa, a cui passo le coordinate (variabili Php)
		var centro = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>);
 		var markers = [];
		
		
		function initMap() {

				  
		var mapOptions = {
					zoom: 11,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					center: centro
				  };

				  var map = new google.maps.Map(document.getElementById('mappa'),
						  mapOptions);
						  
						
				  var originMarker = new google.maps.Marker({
						position: centro,
						map: map,
						icon: 'mapsrosso.png'
				  });
				  

			
 function loadJSON(callback) {   

    var xobj = new XMLHttpRequest();
        xobj.overrideMimeType("application/json");
   	xobj.open('GET', 'dati.json', true);
    xobj.onreadystatechange = function () {
          if (xobj.readyState == 4 && xobj.status == "200") {
            callback(xobj.responseText);
          }
    };
    xobj.send(null);  
 }
 		
	
			loadJSON(function(response) {

    			var result = JSON.parse(response);
    			console.log(result);
    				<?php echo"for (var i=0; i<result.length; i++)
    				{
    					if (result[i].lat!=".$lat." && result[i].lng!=".$lng.") {		
    					nuovo_marker = new google.maps.Marker({
									position: new google.maps.LatLng(result[i].lat,result[i].lng),
									map: map,
									draggable: true,
									title: result[i].descr,
									url: 'index.php?tipo=' + result[i].descr + '&lat=' + result[i].lat + '&lng=' + result[i].lng,
									icon:'mapsnero.png',
									animation: google.maps.Animation.DROP
								  })
						
					  google.maps.event.addListener(nuovo_marker, 'click', function() {window.open(this.get('url'));} );
					  var rectangle = new google.maps.Rectangle({
          				strokeColor: '#0000FF',
         				strokeOpacity: 0.8,
          				strokeWeight: 2,
          				fillColor: '#0000FF',
          				fillOpacity: 0.35,
          				map: map,
          				bounds: {
           				north: result[i].north,
            			south: result[i].south,
            			east: result[i].east,
           				west: result[i].west
         				}
       					});
					  }else
					  	var rectangle = new google.maps.Rectangle({
          				strokeColor: '#FF0000',
         				strokeOpacity: 0.8,
          				strokeWeight: 2,
          				fillColor: '#FF0000',
          				fillOpacity: 0.35,
          				map: map,
          				bounds: {
           				north: result[i].north,
            			south: result[i].south,
            			east: result[i].east,
           				west: result[i].west
         				}
       					});
						
					  }})
					  
					  }";?>

 			
		google.maps.event.addDomListener(window, 'load', initMap);
		
				
		

		

    </script>
	
						
   				 		
			</div>
		
			<!-- HEADING -->
			<div id="potree_description" class="potree_info_text"></div>
		</div>
		
		<div id="potree_sidebar_container"> </div>
    </div>
	
	<script>
	
	function loadJSON(callback) {   

    var xobj = new XMLHttpRequest();
        xobj.overrideMimeType("application/json");
	xobj.open('GET', 'annotazioni.json', true);
    xobj.onreadystatechange = function () {
          if (xobj.readyState == 4 && xobj.status == "200") {
            callback(xobj.responseText);
          }
    };
    xobj.send(null);  
 }
	
	
	
	
		var onPointCloudLoaded = function(event){
			// do stuff here that should be executed whenever a point cloud has been loaded.
			// event.pointcloud returns the point cloud object
			console.log("a point cloud has been loaded");
		}; 
	
		viewer = new Potree.Viewer(document.getElementById("potree_render_area"), {
			"onPointCloudLoaded": onPointCloudLoaded
		});
		
		viewer.setEDLEnabled(false);
		viewer.setPointSize(3);
		viewer.setMaterial("RGB");
		viewer.setFOV(60);
		viewer.setPointSizing("Fixed");
		viewer.setQuality("Squares");
		viewer.setPointBudget(1*1000*1000);
		
		
			
		
	<?php echo'viewer.addPointCloud("../resources/pointclouds/'.$var.'/cloud.js",'?> function(pointcloud){
			 	var result;
				loadJSON(function(response) {

    			result = $.parseJSON(response);
    			
    				for (var i=0; i<result.length; i++)
    				{ <?php echo "if(result[i].id =='" .$var. "')" ?>
    				for (var j=0; j<result[i].nodi.length; j++)
    				{
			 viewer.addAnnotation(new THREE.Vector3(result[i].nodi[j].x, result[i].nodi[j].y, result[i].nodi[j].z), {
					"cameraTarget": new THREE.Vector3(result[i].nodi[j].a, result[i].nodi[j].b, result[i].nodi[j].c),
					"cameraPosition": new THREE.Vector3(result[i].nodi[j].d, result[i].nodi[j].e, result[i].nodi[j].f),
					"title": result[i].nodi[j].title,
					"description": result[i].nodi[j].description
					})}};
 				});	
 			
					
				});
		

		
		viewer.loadGUI();
		
	</script>
  </body>
</html>
