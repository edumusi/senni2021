
<?php include("header_datagrid.php"); ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>

<script>

function muestraDescripcion(text)
{
    var sidediv = document.getElementById('content-window');
    sidediv.innerHTML = text;
}
  
$(document).ready(function() 
{
  var map;
  var myOptions;
  var kmlLayer;

  myOptions = { zoom: 1, center: {lat: 0, lng: 0} };

  map = new google.maps.Map(document.getElementById("map"), myOptions);

  kmlLayer = new google.maps.KmlLayer({
//		url: 'http://senni.com.mx/rastreo/maps/',
//		url: 'http://senni.com.mx/maps/mapaeo.kml',
		url: 'http://senni.com.mx/maps/maps.kml',
//		url: 'http://senni.com.mx/maps/placemark.kml',
//		url: 'http://gmaps-samples.googlecode.com/svn/trunk/ggeoxml/cta.kml',
//		url: 'http://kml-samples.googlecode.com/svn/trunk/kml/Placemark/placemark.kml',
		suppressInfoWindows: true,
	    map: map
	  });
	  
   google.maps.event.addListener(kmlLayer, 'click', function(kmlEvent)
	 { 
	//	muestraDescripcion(kmlEvent.featureData.description); 
		var infowindow = new google.maps.InfoWindow({
      		content: kmlEvent.featureData.description
		  });
		  
		  var marker = new google.maps.Marker({
			  position: new google.maps.LatLng(kmlEvent.featureData.coordinates),
			  map: map			 
		  });
		
		/*var marker = new google.maps.Marker({
			map: map,
			position: map.getCenter()
	  	});*/
		  
		  infowindow.open(map,marker);
	  });    
} );
</script>

<div class="right">
	<img src="<?php echo base_url();?>images/rastreo.gif"  />
</div>

<body onLoad="javascript:loadMap()">
<div id="map" style="height:400px;width:600px"></div>
<div id="content-window" class="panel" style="width:19%; height:100%; float:left"></div>

<?php include("footer.php"); ?>  