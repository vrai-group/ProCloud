<!DOCTYPE html>
<html lang="it">
 
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    <title>Nuvole di punti</title>
    
    
    
</head>
 
<body>
 <script src="../libs/jquery-2.1.4/jquery-2.1.4.min.js"></script>
	<script src="../libs/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <div id="mappa" style="position: absolute; background-color: rgb(229, 227, 223); width: 79%; height: 100%; top: 0px; left: 0px; margin: 0 auto";>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCU8lMT6cqLwbQYoYjds6yblzFEOAMPco8" type="text/javascript"></script>
 <script type="text/javascript">
		 // definisco l'oggetto che rappresenta il centro della mappa
		var centro = new google.maps.LatLng(43.563563,13.573251);
 	
		
function initMap() {

				  
		var mapOptions = {
					zoom: 12,
					center: centro,
					mapTypeControl: true,
          			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
          			navigationControl: true,
          			navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
          			mapTypeId: google.maps.MapTypeId.ROADMAP
				  };

				  var map = new google.maps.Map(document.getElementById('mappa'),
						  mapOptions);
						  		
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
    			
    				for (var i=0; i<result.length; i++)
    				{	
    					 var  content  = '<li>';
                   			content +=  '<a href="index.php?tipo=' + result[i].descr + '&lat=' + result[i].lat + '&lng=' + result[i].lng + '">';
                   			content  += result[i].descr;
                   			content +=  '</a>';
                  			content += '</li>';
 
               				$('ul').append(content);

    					nuovo_marker = new google.maps.Marker({
									position: new google.maps.LatLng(result[i].lat,result[i].lng),
									map: map,
									draggable: true,
									title: result[i].descr,
									url: 'index.php?tipo=' + result[i].descr + '&lat=' + result[i].lat + '&lng=' + result[i].lng,
									icon:'maps.png',
									animation: google.maps.Animation.DROP
								  })
						
					  google.maps.event.addListener(nuovo_marker, 'click', function() {window.open(this.get('url'));} );
					  
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
					  }
					 
 		})
 		
 			
 				 
 			

}

 			
		google.maps.event.addDomListener(window, 'load', initMap);
		
    </script>	
 	
	
    
    </div>
    
      <div id="lista">


		<ul class="style">
   	 		<div class="title">
	   							<h2>Posizioni</h2>
			</div>

     		
		</ul>    	
   </div>
   

</body>
</html>