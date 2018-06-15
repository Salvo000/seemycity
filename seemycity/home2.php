<?php 
	

 if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	// remove all session variables
	//session_unset(); 
	// destroy the session 
	//session_destroy(); 

	// start_session();
	 
?>
<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/home.css" type="text/css" />
	<link rel="stylesheet" href="css/header.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">
</head>
<body>
	<?php
	include("menu.php");
	?>
	<div class = "component" >
				
		<div class = "filter">
				<ul>
					<!-- class="active" quando sarò nella pagina di uno dei 3 filtri -->
		  			<li><a href="citta.php"><h2>Citta<h2></a></li>
		  			<li><a href="eventi.php"><h2>Eventi<h2></a></li>
		  			<li><a href="percorsi.php"><h2>Percorsi<h2></a></li>
		  			<li><a href="attrattive.php"><h2>Attrattive<h2></a></li>
		  			<li><a href="preferiti.php"><h2>Preferiti<h2></a></li>
				</ul>
		</div>
		<div class = "nav" >
			<?php
				echo ("<h1> Ciao ".$_SESSION["uname"]." scorri in basso per trovare gli eventi, le attrattive e i percorsi nelle tue vicinanze! </h1> ");
				print_r($_SESSION);

				include_once('connection.php');
				$pdo = new Connection();
				
				try {
					
					//nome citta è chiave in tabelle citta
     				$sql_eventi='SELECT * FROM Evento  WHERE (NomeCitta=" '.$_SESSION["citta"].';';
     				$sql_percorsi='SELECT * FROM Percorso  WHERE (NomeCitta=" '.$_SESSION["citta"].';';
     				
     				
     				$res_eventi  = $pdo->query($sql_eventi);
     				$res_percorsi = $pdo->query($sql_percorsi);
     				$row_eventi = $res_eventi -> fetch();
     				echo "Titolo : ".$row_eventi["Titolo"];
					while(	$row_eventi = $res_eventi -> fetch() )
					{

						echo('"
								<table>
									<td>
										<tr ><h3>'.$row_eventi["Titolo"].'</h3></tr>
										<tr >
											<p id="data" >Data '.$row_eventi["Data"].' h: '.$row_eventi["OrarioInizio"].'</p>
										</tr>
										<tr>
											<p>Stato : '.$row_eventi["Stato"].' </p>
										</tr>
										<tr>
											<td><p id="pos" >Luogo: '.$row_eventi["AttivitaCommerciale"] .' </p></td>
											<td><button onclick="mostraMappaFunction()"> Mostra mappa</button></td>
										</tr>
										<tr >
											<td colspan="2"> 
												<p id="desc" >
												<br>
												</p>
											</td>
										</tr>
										<tr>
											<td>
												<button>Aggiungi ad un tuo Percorso</button>
											</td>
											<td>
												<button>Commenta</button>
											</td>
										</tr>
									</td>
								</table>
							"');
					}

				}catch(PDOException $e) {
    					echo("[ERRORE] Query SQL (get Eventi) non riuscita. Errore: ".$e->getMessage());
    					exit();
  				}

				print_r($_SESSION);
			?> 
			
						
		</div>
		
		<?php
			include("footer.php");
		?>
	</div>
</body>
</html>