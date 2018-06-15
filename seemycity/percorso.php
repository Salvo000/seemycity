<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

  include_once('path.php');
  $object = new Path();

    if(isset($_POST['aggiungiPreferiti'])){
		// $object = new Path();
		$nota = addslashes($_POST["notaDescrittiva"]);
		$object -> insertFavoritePath($_SESSION['uname'], $_SESSION['codicePercorso'],$nota);
 	}
 	
  $res = $object -> displayListaAttrattiveInPercorso($_SESSION['codicePercorso']);

  $listaCoordinate;
  $tot;
  if (count($res) != 0) {
  	for ($row = 0; $row < count($res); $row++) {
  		$attrattiva = $res[$row][1];
  		$attrattiva = addslashes($attrattiva);
  		$citta = $res[$row][2];
  		$object2 = new Path();
  		$listaCoordinate[] = $object2 -> displayCoordinateAttrattiva($attrattiva, $citta);
  	}
  	$tot = count($listaCoordinate);
  }

  //$tot = count($listaCoordinate);

  


 ?>
<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/percorso.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

    <meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">

</head>
<body>
<?php
	include("menu.php");
	?>
<div class="content">
	<div class="container" align="center">
	<?php 
    	echo('<h3 class="ex2" align="center"> Percorso '.$_SESSION["codicePercorso"].'</h3');
	?>
	  <p align="center">Attributi del percorso (codice, durata, numero attrattive)</p>            
	  <table class="table table-condensed">
	    <thead>
	      <tr>
	        <th>Ordine di visita</th>
	        <th>Attrattiva</th>
	        <th>Città</th>
	        <th>Tempo visita</th>
	      </tr>
	    </thead>
	    <tbody>
	      <?php
		    if (count($res) == 0) {
		        echo "<h1> NON CI SONO PERCORSI </h1>";
		    }
		  ?>
		  <?php for ($row = 0; $row < count($res); $row++) { ?>
			<tr style="cursor:hand">
			  <?php for ($col = 0; $col < count($res[$row]); $col++) { ?>
			   <td><?php echo " ".$res[$row][$col]." "; ?></td>
			  <?php } ?>
			</tr>
		  <?php } ?>
	    </tbody>
	  </table>
	  <!-- <textarea name="notaDescrittiva" placeholder="Aggiungi una nota prima di aggiungere questo percorso fra i tuoi preferiti"></textarea> -->
	  	<button type="submit" onclick="document.getElementById('id01').style.display='block' "> 
	      Preferiti</button>
	  	<!-- <button onclick="document.getElementById('id01').style.display='block'">Preferiti</button> -->
	  	<?php
	  	include("addPathToFavorities.php");
	  	?>
	</div>

	<div class="mapContainer">
	 <h2 align="center">Visualizza il percorso con Google Maps</h2>
	 <p align="center">Attributi del percorso (codice, durata, numero attrattive)</p>
	<div id="map">My map will go here</div>


	</div>
	<?php
	include('footer.php');
	?>
</div>


<script>
	function myMap() {

		var tot = <?php echo $tot ?>;
		var lista = <?php echo json_encode($listaCoordinate) ?>;
		var lon = lista[0][0][1];
		var lat = lista[0][0][2];

		var poly = new Array();
		var j;    
		for (j = 0; j<tot; j++) {
		    var pos = new google.maps.LatLng(lista[j][0][2],lista[j][0][1]);
		    poly.push(pos);
		}

		var map = new google.maps.Map(document.getElementById('map'), {
		  zoom: 13,
		  center: new google.maps.LatLng(lat, lon),
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		var infowindow = new google.maps.InfoWindow();

		var marker, i;
		var markers = [];

		for (i = 0; i < tot; i++) {  
		  marker = new google.maps.Marker({
		    position: new google.maps.LatLng(lista[i][0][2], lista[i][0][1]),
		    map: map
		  });

		  markers.push(marker);

		  addInfoWindow(marker, lista[i][0][0]);
		}

		function addInfoWindow(marker, message) {

            var infoWindow = new google.maps.InfoWindow({
                content: message
            });

            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.open(map, marker);
            });
        }

		//console.log(markers[0]);

		var flightPath = new google.maps.Polyline({
		  path: poly,
		  strokeColor: "#0000FF",
		  strokeOpacity: 0.6,
		  strokeWeight: 4
		});
		flightPath.setMap(map);



  	}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdkrR-Ma_TWsHe0wwnxrCtQHBwb41qrWk&callback=myMap"></script>

</body>
</html>