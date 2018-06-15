<?php

	if(!isset($_SESSION)){
 		session_start();
	}
	
	include_once('attraction.php');

	if(!isset($object)){
		$object = new Attraction();
	}

	

?>	
<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/attrattiva.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
	<!-- <link rel="stylesheet" href="css/eventi.css" type="text/css" />	 -->
	<link rel="stylesheet" href="hxttps://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<!-- <link rel="stylesheet" href="css/eventi.css" type="text/css" />	 -->

	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
	

    <meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">

</head>
<body>
  <?php
	include("menu.php");
	?>
  <div class="content">
 	<div class="container" align="center">
	   <?php
  
				if(isset($_POST["info"])){
					if(isset($_POST["titoloEvento"])){
						$titoloEvento = $_POST["titoloEvento"];
						$descrizioneEvento = $_POST["descrizioneEvento"];
						$dataEvento = $_POST["dataEvento"];
						$orarioInizioEvento= $_POST["orarioInizioEvento"];
						$capienzaMaxEvento = $_POST["capienzaMaxEvento"];
						$statoEvento = $_POST["statoEvento"];
						
					}

					$_SESSION["nomeAttrattiva"] = $_POST["nome"];
					$_SESSION["cittaAttrattiva"] = $_POST["citta"];
					$_SESSION["indirizzoAttrattiva"] = $_POST["indirizzo"];
					$_SESSION["lngAttrattiva"] = $_POST["lng"];
					$_SESSION["latAttrattiva"] = $_POST["lat"];
					$_SESSION["autoreAttrattiva"] = $_POST["nickname"];
					$_SESSION["fotoAttrattiva"] = $_POST["foto"];
				}
				if(isset($titoloEvento)){
					echo('<h2 align="center">'.$titoloEvento.' at '.$_SESSION["nomeAttrattiva"].'</h2>');
					echo('<table class="table table-condensed">');
						echo('<tbody>');
							echo('<tr>');
								echo('<td colspan="4">'.$descrizioneEvento.'</td>');
							echo('</tr>');
							echo('<tr>');
								echo('<td>Data: '.$dataEvento.'</td>');
								echo('<td>OraInizio: '.$orarioInizioEvento.'</td>');
								echo('<td>CapienzaMax:'.$capienzaMaxEvento.'</td>');
								echo('<td>Stato:'.$statoEvento.'</td>');
							echo('</tr>');
						echo('</tbody>');
					echo('</table>');
	  
				}
				else{
					echo('<h2 align="center">'.$_SESSION["nomeAttrattiva"].'</h2>');
				}
  	?>
		<table class="table table-condensed">
	    <thead>
	      <tr>
	        <th>Citta</th>
	        <th>Indirizzo</th>
	        <th>Longitudine</th>
	        <th>Latitudine</th>
	        <th>Postata da</th>
	        <th>Foto</th>
	        <th>Recensioni</th>
	      </tr>
	    </thead>
	    <tbody>
	      <tr>
	      <?php
				// echo('<td>'.$nome.'</td>');
				echo('<td>'.$_SESSION["cittaAttrattiva"].'</td>');
				echo('<td>'.$_SESSION["indirizzoAttrattiva"].'</td>');
				echo('<td>'.$_SESSION["lngAttrattiva"].'</td>');
				echo('<td>'.$_SESSION["latAttrattiva"].'</td>');
				echo('<td>'.$_SESSION["autoreAttrattiva"].'</td>');
				
	      ?>
	      <td><button onclick="document.getElementById('id03').style.display='block'"> 
	      Mostra Foto</button></td>
	      <td><button onclick="document.getElementById('id01').style.display='block'"> 
	      Commenta</button></td>
	      <?php
	      include("showFoto.php");
	      include("createCommento.php");
	      ?>

	      </tr>
	      <!-- <tr>
	      	 <th colspan="7"><p align="center">LASCIA UN COMMENTO! </p></th> 
	      	<td colspan="7"><img src="/uploads/.." align="center" alt="Titolo"></td>
	      </tr> -->
	    </tbody>
	  </table>
	</div>
	<?php
		include"getAffluenza.php";
	?>
	<div class="mapContainer">
	 <!-- <h2 align="center">Visualizza la posizione dell'attrattiva con Google Maps</h2> -->
		<div id="map"></div>
	</div>
	

	
	<div class="container" align="center">
		<h2 align="center">COMMENTI</h2>
		<table class="table table-condensed">
	    <thead>
	    	<tr><th colspan="2"</th></tr>
		<?php
		// echo('<tr><p> ==> '.$nome.' , '.$citta.','.$object.' </p></tr>');
		// echo(isset($nome,$citta,$object));
				if(isset($_POST["newComment"])){

				$recensione1 = $_POST["recensione"];
				$recensione = addslashes($recensione1);
				$votazione = $_POST["votazione"];
				$tempoVisita = $_POST["ora"];
				$giornoVisita = $_POST["giornovisita"];
				$nomeAttrattiva = $_SESSION["nomeAttrattiva"];
				$nickname = $_SESSION["uname"];
				$citta = $_SESSION["cittaAttrattiva"];
				$object->addComment($recensione, $votazione, $tempoVisita, $giornoVisita, $nomeAttrattiva,$citta,$nickname);
				
				}

				$res = $object->getCommentiAttrattiva($_SESSION["nomeAttrattiva"],$_SESSION["cittaAttrattiva"]);

				while ($row = $res->fetch()) {
					echo('<tr><th>'.$row["NicknameUtente"].'</th><th>'.$row["DataInserimento"].'</th></tr>');
					echo('</thead>');
					echo('<tbody>');
					echo('<tr>');
	    			echo('<td colspan="2">'.$row["Recensione"].'</td>');
	    			echo('</tr>');
	    			echo('<tr>');
	    			echo('<td colspan="2">'.$row["Votazione"].'</td>');
	    			echo('</tr>');
	    			echo('<tr>');
	    			echo('<td>'.$row["GiornoVisita"].'</td>');
	    			echo('<td>'.$row["TempoVisita"].'</td>');
	    			echo('</tr>');
	    			echo('</tbody>');
				}
			


		
		?>
	  
	    	
	    
	    
	    
	    </table>
	</div>
	

</div>

<script>
	function myMap() {
		/*Creo le posizioni*/
		var lat = <?php echo($_SESSION["latAttrattiva"]) ;?>;
		var lng = <?php echo($_SESSION["lngAttrattiva"]) ;?>;

		var basilicaDom = new google.maps.LatLng(lat, lng);
		var mapCanvas = document.getElementById("map");
		var mapOptions = {center: basilicaDom, zoom: 13};
		var map = new google.maps.Map(mapCanvas,mapOptions);
		/*Aggiungo i marker alle posizioni*/
		var marker1 = new google.maps.Marker({position:basilicaDom});
  		marker1.setMap(map);

  		addInfoWindow(marker1, "<?php echo($_SESSION["nomeAttrattiva"]);?>"); 


		/*Aggiungo il quadratino con l'informazione se clicco sul marker*/
		function addInfoWindow(marker, message) {

            var infoWindow = new google.maps.InfoWindow({
                content: message
            });

            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.open(map, marker);
            });
        }
	}	
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdkrR-Ma_TWsHe0wwnxrCtQHBwb41qrWk&callback=myMap"></script>


</body>
</html>