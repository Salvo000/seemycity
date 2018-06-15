<?php
//https://www.mrwebmaster.it/javascript/semplice-chat-ajax-php_7425_4.html
	if(!isset($_SESSION)){
		session_start();
		// echo "session_start in chat.php";
	}
	include_once("user.php");
	
	include_once('connection.php');
	
	$pdo = new Connection();
	$pdo = $pdo -> dbConnect();

	if(isset($_POST["send"]) && isset($_POST["desc"]) ){
		$user_receiver = $_SESSION["receiver"];
		$descrizione = $_POST["desc"];
		$titolo = $_POST["titolo"];
		$mittente = $_SESSION["uname"];
		if(!isset($object))
    	{ 
    		$object = new User();
    	}
    	// echo("Prima della richiesta");
		$response = $object ->sendMessage($_POST["titolo"], $descrizione, $mittente , $user_receiver);
		// echo("dopo della richiesta");

		//echo "<p><br><br>".$response."</p>";
	}

	/*
		ho bisogno di una classe che mi gestisca 
	"chat.php": sarà la parte più importante del front-end, consentirà infatti di inserire messaggi e leggerli.conterrà il codice preposto all'inserimento dei messaggi generando i diversi records.

	"chat.js": il file che conterrà il codice Javascript per l'aggirnamento dell'interfaccia di discussione.. 

	"ajax.php": avrà il compito di estrarre, contare e mostrare i messaggi scritti dagli utenti.
	*/

?>


<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	

<!-- Bootstrap core CSS -->
   <!--  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> -->

	<!--<link rel="stylesheet" type="text/css" href="menu.css">-->
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
 -->
<!-- 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->

	<meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">
	<script src="script1.js"></script>
	<link rel="stylesheet" href="css/chat.css" type="text/css" />
	<!-- <link rel="stylesheet" href="css/header.css" type="text/css" /> -->
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
</head>
<body>
<?php
	include("menu.php");
?>
	<div class = "users">
		<table>
			<form name="cronos" method="post" action="chat.php">
<?php
	//prendo tutti i messaggi che hanno messaggi non letti e li metto in alto.
	//si può migliorare metto in alto gli ultimi a cui ho scritto oppure l'ultimo messaggio ricevuto

	$query_utenti = "SELECT DISTINCT(NicknameMittente) FROM messaggio WHERE NicknameDestinatario = '".$_SESSION['uname']."' or NicknameMittente in(select NicknameDestinatario FROM messaggio where NicknameMittente = '".$_SESSION['uname']."') ORDER BY Codice DESC";

	//$query_utenti = "Select NicknameMittente from Messaggio where NicknameMittente<>'".$_SESSION['uname']."' group by NicknameMittente order by Codice desc";
	
	

	$res_utenti  = 	$pdo->query($query_utenti);
	while(	$row_utenti = $res_utenti -> fetch() )
	{
		echo('<tr><td><button name = "button" value="'.$row_utenti["NicknameMittente"].'" >'.$row_utenti["NicknameMittente"].'</button></td></tr>');
	}
	
	 //echo " <tr><td><p> -------- </p></td></tr>";

	$query_utenti = "select Nickname from Utente where (Utente.Stato=1 and Utente.Nickname<>'".$_SESSION['uname']."' and Utente.Nickname not in (SELECT DISTINCT(NicknameMittente) FROM messaggio WHERE NicknameDestinatario = '".$_SESSION['uname']."' or NicknameMittente in(select NicknameDestinatario FROM messaggio where NicknameMittente = '".$_SESSION['uname']."') ORDER BY Codice DESC) ) ORDER BY Nickname";
	
	//$query_utenti = "select Nickname from Utente where (Utente.Stato=1 and Utente.Nickname<>'".$_SESSION['uname']."' and Utente.Nickname not in (Select NicknameMittente from Messaggio where NicknameMittente<>'".$_SESSION['uname']."' group by NicknameMittente order by Codice desc) ) ORDER BY Nickname";
	
	$res_utenti  = 	$pdo->query($query_utenti);
	while(	$row_utenti = $res_utenti -> fetch() )
	{
		echo('<tr><td><button name = "button" class="buttonUser" value="'.$row_utenti["Nickname"].'" >'.$row_utenti["Nickname"].'</button></td></tr>');
	}

?>		
			</form>
		</table>
	</div>
	<div class = "nav" id="cronologia" >
		<table>

<?php
	if(	isset($_POST["button"]) || isset($_SESSION["receiver"]) && ( $_SESSION["receiver"]!= $_SESSION["uname"])){

		if(isset($_POST["button"]))
		{
			$_SESSION["receiver"] = $user_receiver = $_POST["button"];

		}else
		{
			$user_receiver = $_SESSION["receiver"];
		}
		
    	if(!isset($object))
    	{ 
    		$object = new User();
    	}
    	$res = $object->getListaMessaggi($_SESSION["uname"],$user_receiver);
		// $object ->sendAckVisualized($user_receiver);
		while($row =$res->fetch() ){

			if($row["NicknameMittente"] == $_SESSION["uname"]){
					
				// echo" sono mittente";
				echo('<tr><td><div class="receiver"><p text-align = "right" ><br><b>'.$row["Titolo"]." </b> <br>'".$row["Descrizione"]."'</p> </div></td> </tr> " );
			}
			else
			{
				// echo" sono destinatario";
				// echo('<tr><td><p text-align = "left"> "received >" <br><b> '.$row["Titolo"]."</b> <br>' ".$row["Descrizione"]."'</p> </td> </tr> " );
				echo('<tr><td><div class="sender"><p text-align = "left"> <br><b> '.$row["Titolo"].'</b> <br> '.$row["Descrizione"].'</p> </div></td> </tr> ' );
				
			}

		}
	}//close if set Post_button
	else{
		echo(" <tr><td><h3><br><br>Scegli un utente a cui vuoi inviare un messaggio</h3></td></tr> ");	
	}



?>
			</table>
		</div>
	<div class = "message">
			<table>
				<tr>
					<td id = "col">
					<!-- <i class="material-icons" style="font-size:60px;color:red;text-shadow:2px 2px 4px #000000;">favorite</i><i class="material-icons" style="font-size:60px;color:lightblue;text-shadow:2px 2px 4px #000000;" >attachment</i> -->
					</td>
					<!-- <td id = "col" ></td> -->
					<td id = "col2" >
						<form  action = "chat.php" method="post">
							<input id="col3" type="text" size="50" maxlength="200" name="titolo" placeholder="Inserisci un titolo" >
							<input id="col3" type="text" size="50"  name="desc" placeholder="Corpo del messaggio" >
							
							<input type="submit" value="send" name="send" >
							<?php 
								if( !isset($user_receiver) && (!isset($_SESSION["receiver"])) )
									echo ("<p> Nessun utente! </p>");
								else if(isset($user_receiver)){
									$_SESSION["receiver"] = $user_receiver;
									echo "<p>clicca su send per inviare un messaggio a ".$user_receiver."</p>";
								}
								else{
									echo "<p>clicca su send per inviare un messaggio a ".$_SESSION["receiver"]."</p>";
								}
							?>
						</form>
					</td>

				</tr>
			</table>
	</div>
	
	<?php
	include("footer.php");
	?>

</body>
</html>