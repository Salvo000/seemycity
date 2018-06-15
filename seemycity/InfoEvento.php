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
		<meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">
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
		<div class = "menu">
				
				<h1>Cerchi un Evento?</h1>
				
				<h3>Cerca un evento in una nuova città</h3>
				<table>
					<tr>

						<td id="col1">
							<form method="POST" action="eventi.php">
<?php
			echo('<input type="text" name="citta" placeholder="Es. '.$_SESSION['citta'].'">');
?>								
								<p>Dal :</p>
								<input type="date" id="dataPikerStart" name="datePikerStart" onkeydown="return false" required>
								<p> al : </p> <input type="date" name="datePikerEnd" id ="dataPikerEnd" onkeydown="return false" required>
								<button name="cercabutton" >Cerca</button>
							</form >
						</td>
						
							<?php
								$tipo=$_SESSION["tipo"];
								// $tipo="Semplice";
								
								if($tipo=="Gestore"){
									echo "<td id='col2'>";
									include("createEvent.php");
									echo "</td>";
								}
								
							?>
					</tr>
				</table>
				
		</div> 
		<div class = "nav" >
						
<?php
				//ritorno gli eventi nelle mie vicinanze di questa settimana
				echo('<div class="eventContainer">');
				

				if(isset($_POST['cercabutton'])){
					echo('<h1>Eventi trovati: </h1>');
					$citta=$_POST['citta'];
					$dataPikerStart=$_POST['datePikerStart'];
					$dataPikerEnd=$_POST['datePikerEnd'];
					$res_eventi = $object->getEvent($citta,$dataPikerStart,$dataPikerEnd);
				}else{
					
					if(isset($_POST["commenta"]))
						$res_eventi = $object->getInfoEvento($_POST["commenta"]);
				}

					while(	$row = $res_eventi->fetch() && )
					{
						
						// echo"suca";
						echo('<table>');
						
							echo('<tr><h3>'.$row['Titolo'].'</h3></tr>');
							echo('<tr><p id="data" >Data '.$row['Data'].' h: '.$row['OrarioInizio'].'</p></tr>');
							echo('<tr><p>Stato : '.$row['Stato'].' </p></tr>');
							
							echo("<tr>");
								echo('<td><p id="pos" >Pos: '.$row['Indirizzo'].' </p></td>');
								echo('<td><button onclick="mostraMappaFunction()"> Mostra mappa</button></td>');
							echo("</tr>");
							echo("<tr>");
								echo('<td colspan="2"><p id="desc" >'.$row['Descrizione'].'</p></td>');
							echo("</tr>");
							echo("<tr>");
							echo('<td>');
							echo("<button>Aggiungi ad un tuo Percorso</button>");
							echo('</td>');
							echo('<td>');
								echo('<button>Commenta</button>');
							echo('</td>');
							echo('</tr>');
						echo('</table>');
						echo "<p> <br><br>---- <br><br> </p>";
					}
				
				}
				// </table>
				echo "</div>";

				else{


				}

?>
		</div>
			
		<?php
			include("footer.php");
		?>
		<script type="text/javascript">
			
			function mostraMappaFunction(){
				//non ho idea di come farla comparire massimo vedi se trovi qualche idea

			}
		</script>
		<?php
		include("footer.php");
		?>
	</body>
	
</html>