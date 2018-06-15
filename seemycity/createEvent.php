<!-- <head>
	<link rel="stylesheet" href="css/eventi.css" type="text/css" />	
</head> -->
<!-- Button to open the modal login form -->
<button onclick="document.getElementById('id01').style.display='block'">Nuovo Evento</button>

<!-- The Modal -->
<div id="id01" class="modal">
	<span onclick="document.getElementById('id01').style.display='none' "  class="close" title="Close Modal">&times;</span>
<!-- Modal Content -->
<form class="modal-content animate" method="POST" action="eventi.php">
  	<div class="container">
		<label ><b>Attrattiva: </b></label>
  		<select name="nomeAttrattiva">
<?php
  				//faccio una query e mi faccio tornare tutti i nomi di quell'utente
  				$sql = 'select Nome, NomeCitta from Attrattiva where NicknameUtente = "'.$_SESSION['uname'].'" and EXISTS(SELECT * from AttivitaCommerciale)';
  				
				include_once('connection.php');
				$pdo = new Connection();
			 	$pdo = $pdo -> dbConnect();
  				$res = $pdo->query($sql);
  				if(!isset($res)){
  					echo("[Error] query NomeAttrattive doesn't work ");
  					exit();
  				}else{
	  					while(	$row = $res -> fetch() )
						{
						echo('<option value="'.$row["Nome"].'">'.$row["Nome"].' - '.$row["NomeCitta"].'</option>');
						}
  				}

?>
  			
  		</select>
		<label for="titolo"><b>Titolo Evento:</b></label>
		<input type="text" placeholder="Inserisci il titolo del tuo evento" name="titolo" required>
		<br>
		<label for="descrizione"><b> Descrizione: </b></label>
		<input type="text" placeholder="Inserisci una descrizione" name="descrizione" required>
		<br>
		<label for="data"><b> Giorno dell'evento: </b></label>
		<input type="date" name="data" required>
		<br>
		<label for="ora"><b> Ora di inizio dell'evento: </b></label>
		<input type="time" name="ora" required>
		<br>
		<label for="capienzaMax"><b> Numero di posti: </b></label>
		<input type="number" name="capienzaMax" >
		<br>
					
		<button type="submit" name="newEvent" >Crea Evento</button>
	</div>
	<div class="container" style="background-color:#f1f1f1">
    
    <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
    </div>
</form>
<script>
		// Get the modal
		var modal = document.getElementById('id01');

		// When the user clicks anywhere outside of the modal, close it
		window.onclick = function(event) {
    		if (event.target == modal) {
        		modal.style.display = "none";
    		}
		}
</script>


