<?php
	if(!isset($_SESSION)){
		session_start();
	}

include_once('event.php');

if(!isset($object)){
	$object = new Event();
}
	


	if(isset($_POST["newEvent"])){
		$titolo = $_POST["titolo"];
		$descrizione = $_POST["descrizione"];
		$data = $_POST["data"];
		$orarioInizio = $_POST["ora"];
		$capienzaMax = $_POST["capienzaMax"];
		$stato = "Aperto";
		$attivitaCommerciale = $_POST["nomeAttrattiva"];
		$nomeCitta = $_SESSION["citta"];
		$nicknameUtente = $_SESSION["uname"];

		// echo "Sto per eseguire addEvent ";
		$object -> AddEvent($titolo, $descrizione, $data, $orarioInizio, $capienzaMax, $stato, $attivitaCommerciale, $nomeCitta, $nicknameUtente);

	}

	if(isset($_POST["followEvent"])){
		$ris = $object ->followEvent($_SESSION["uname"],$_POST["titolo"]);
		$_POST["cercabutton"]= 1;
		
	}

	if(isset($_POST["notFollowMore"])){
		$object ->unfollowEvent($_SESSION["uname"],$_POST["titolo"]);
		$_POST["cercabutton"]= 1;
		
	}



	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>SeeMyCity</title>
		<link rel="stylesheet" href="css/eventi.css" type="text/css" />
		<link rel="stylesheet" href="css/menu.css" type="text/css" />
		<link rel="stylesheet" href="css/footer.css" type="text/css" />
		
		 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>

		 <!-- Bootstrap core -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY&callback=myMap"></script>
	
		<meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0"> 

<style type="text/css">
			
#contenitore{
    display: grid;
    width: 100%;
    height: 100%;
    grid-template-areas:"a a a"
                        ". b ."
                        ". b .";
    
    grid-template-rows: 1fr 2fr 2fr;
    grid-template-columns: 10% 80% 10%;
    font-family: Arial, Helvetica, sans-serif;
    float : center;

}

.menu{
    grid-area: a;

	margin-left: 0px;
	margin-right: 0px;
	/*margin-top: 150px;*/
    width: 100%;
    background-color: lightgrey;
    background-size: 30px 30px;
    background-position: 5px 5px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    /*border: 1px solid #ddd; /* Add a grey border */
    /*margin-bottom: 12px;  Add some space below the input */

}
.nav{
    grid-area: b;
    /*float : center;*/
    width: 100%;
    height: 100%;
}

		</style>
</head>
	<body>
		<?php
		include("menu.php");
		?>
	<!-- una barra sotto header dove metto titolo e 2 operazioni:
					1: ricerca di tutti gli eventi in una citta in un determinato periodo di tempo 

					2: inserire un nuovo evento in un attività commerciale se sei un gestoreAttività.

					

					poi compare la lista di tutti gli eventi in ordine di post! e di ognuno c'è commenta o aggiugi a percorso e nel caso aggiungo ad un percorso 
				-->
		<section id="contenitore">
		<div class="menu">
				
				<h1>Cerchi un Evento?</h1>
				
				<h3>Cerca un evento in una nuova città</h3>
				<table class="table table-condensed" >
					<tr>

						<td id="col1">
							<form method="POST" action="eventi.php">
<?php
			echo('<input type="text" name="citta" placeholder="Es. '.$_SESSION['citta'].'" required>');
?>								<br><br>
								<p>&nbsp; Dal : &nbsp;
								<input type="date" id="dataPikerStart" name="datePikerStart" onkeydown="return false" required>
								 &nbsp; al :  &nbsp; <input type="date" name="datePikerEnd" id ="datePikerEnd" onkeydown="return false" required></p>
								<br><p><button name="cercabutton" >Cerca</button>
							</form >
								<?php
								$tipo=$_SESSION["tipo"];
								// $tipo="Semplice";
								//echo($tipo);
								if(strcasecmp($tipo, "Gestore") == 0){
									// echo "<td id='col2'>";
									include("createEvent.php");
									// echo "</td>";
								}
								
							?>
							</p>
						</td>
						
							
					</tr>
				</table>
				
		</div> 
		<div class="nav" >
						
<?php
				//ritorno gli eventi nelle mie vicinanze di questa settimana
				echo('<div class="container">');
				

				if(isset($_POST['cercabutton'])){
					echo('<h1>Eventi trovati: </h1>');
					$citta=$_POST['citta'];
					$dataPikerStart=$_POST['datePikerStart'];
					$dataPikerEnd=$_POST['datePikerEnd'];
					
						echo("<p>Dal :".$dataPikerStart);
						 echo(" Al :".$dataPikerEnd);
						 echo(" A :".$citta." </p>");

					$res_eventi = $object->getEvent($citta,$dataPikerStart,$dataPikerEnd);
				}else{
					echo('<h1>Ecco prossimi eventi nelle vicinanze.. </h1>');
					//$res_eventi = $object -> getListaEventi($_SESSION["citta"]);
					$citta=$_SESSION['citta'];
					$dataPikerStart='2018-01-01';
					$dataPikerEnd='2018-12-31';
					$res_eventi = $object->getEvent($citta,$dataPikerStart,$dataPikerEnd);
				}

				$res_events_followed = $object->getEventsFollowed($_SESSION["uname"]);
				
				while(	$row = $res_eventi->fetch() )
				{


					echo('<table class="table table-condensed">');
					echo('<form method="POST" action="attrattiva.php"> ');
					echo('<input type="hidden" name="titoloEvento" value="'.$row["Titolo"].'">');
					echo('<input type="hidden" name="descrizioneEvento" value="'.$row["Descrizione"].'">');
					echo('<input type="hidden" name="dataEvento" value="'.$row["Data"].'">');
					echo('<input type="hidden" name="orarioInizioEvento" value="'.$row["OrarioInizio"].'">');
					echo('<input type="hidden" name="statoEvento" value="'.$row["Stato"].'">');
					echo('<input type="hidden" name="capienzaMaxEvento" value="'.$row["CapienzaMax"].'">');
					echo('<input type="hidden" name="nome" value="'.$row["Nome"].'">');
					echo('<input type="hidden" name="citta" value="'.$row["NomeCitta"].'">');
					echo('<input type="hidden" name="indirizzo" value="'.$row["Indirizzo"].'">');
					echo('<input type="hidden" name="lat" value="'.$row["Latitudine"].'">');
					echo('<input type="hidden" name="lng" value="'.$row["Longitudine"].'">');
					echo('<input type="hidden" name="nickname" value="'.$row["NicknameUtenteGestore"].'">');
					echo('<input type="hidden" name="foto" value="'.$row["foto"].'"> ');
					// echo('<input type="hidden" name="follow" value=""> ');
					//0 = follow event
					//1 = 
					
						echo('<tr><h3>'.$row['Titolo'].'</h3></tr>');
						echo('<tr> Data '.$row['Data'].' h: '.$row['OrarioInizio'].'</p></tr>');
						echo('<tr><p> Stato : '.$row['Stato'].' </p></tr>');
						
						echo("<tr>");
							echo('<td><p id="pos" > Pos: '.$row['Indirizzo'].' </p></td>');
							
						echo("</tr>");
						echo("<tr>");
							echo('<td colspan="2"><p id="desc" >'.$row['Descrizione'].'</p></td>');
						echo("</tr>");
						echo("<tr>");
					
				echo('<td><button name="info"> Mostra sulla mappa</button></td>');
				echo'</form>';
				echo('<td>');

				//vedo se il nome dell'evento è fra gli eventi che seguo e così so cosa stampare 
				

				echo('<form method="post" action="eventi.php">');
				//$citta = $_SESSION['citta'];
				//$dataPikerStart = '2018-05-01';
				//$dataPikerEnd = '2018-05-30';

				echo('<input type="hidden" name="citta" value="'.$citta.'">');

				echo('<input type="hidden" name="datePikerStart" value="'.$dataPikerStart.'">');
				echo('<input type="hidden" name="datePikerEnd" value="'.$dataPikerEnd.'">');
				echo('<input type="hidden" name="titolo" value="'.$row['Titolo'].'">');
				
				
				$isFollower = false;
				
				
				for($i=0; $i<count($res_events_followed); $i++){
					
					// echo("i >>".$i);
					// echo "Confronto = ".$res_events_followed[$i][0];
					// echo " con = ".$row["Titolo"];

					if(strcmp($res_events_followed[$i][0], $row["Titolo"]) == '0'){
						$isFollower = true;
						break;
					}
				}
				if($row['Stato']=="Aperto"){
						if(!$isFollower){
						echo('<button name="followEvent">Follow </button>');
					}else{
						echo('<button name="notFollowMore">Unfollow </button>');
					}
				}
				
					echo('</form>');
				echo('</td>');

						echo('</tr>');
					echo('</table>');
					
					// echo "<p> <br><br>----<br><br> </p>";
				}
				// </table>
				echo "</div>";

?>
		</div>
		<?php
		include("footer.php");
		?>
	<script>
	function myMap() {
		/*Creo le posizioni*/
		var lng = <?php echo($_SESSION["latAttrattiva"]) ;?>;
		var lat = <?php echo($_SESSION["lngAttrattiva"]) ;?>;

		var basilicaDom = new google.maps.LatLng(lat, lng);
		var mapCanvas = document.getElementById("map");
		var mapOptions = {center: basilicaDom, zoom: 13};
		var map = new google.maps.Map(mapCanvas,mapOptions);
		/*Aggiungo i marker alle posizioni*/
		var marker1 = new google.maps.Marker({position:basilicaDom});
  		marker1.setMap(map);

  		addInfoWindow(marker1, "Nome attrattiva");


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

	</section>
	</body>
	
</html>