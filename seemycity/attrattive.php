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
	<link rel="stylesheet" href="css/attrattive.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

	

	<!--<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>-->

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

	<div class="container">
	  <!--<div class="row">-->
	      <!--<div class="panel panel-default">-->
	        <div class="panel-heading" align="center">
	          <h4>
	            Lista delle attrattive 
	          </h4>
	        </div>
	        <div class="panel-content" align="center" >
	          <h4>
	            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cerca l'attrattiva per città...">
	          </h4>
	        </div>
	        <table class="table table-fixed" id="myTable">
	          <thead>
			    <tr bgcolor="#f1f1f1">
			      <th scope="col">Nome</th>
			      <th scope="col">Città</th>
			      <th scope="col">Indirizzo</th>
			      <th scope="col">NicknameUtente</th>
			      <th scope="col">Info</th>
			    </tr>
			  </thead>
	          <tbody>
	          	
		        <?php 
		        	$res = $object -> displayListaAttrattive();
		        	
		        	// foreach ($res as $row) {
		        	while($row = $res->fetch() ){
		        		echo('<tr style="cursor:hand">');
		        		echo('<form method="POST" action="attrattiva.php"> ');
		        		echo('<td><input type="hidden" name="nome" value ="'.$row['Nome'].'" >'.$row['Nome'].'</td>');
		        		echo('<td><input type="hidden" name="citta" value ="'.$row['NomeCitta'].'" >'.$row['NomeCitta'].'</td>');
		        		echo('<td><input type="hidden"name="indirizzo" value ="'.$row['Indirizzo'].'" >'.$row['Indirizzo'].'</td>');
		        		echo('<td><input type="hidden"name="nickname" value ="'.$row['NicknameUtente'].'" >'.$row['NicknameUtente'].'</td>');
		        		echo('<input type="hidden" name="lat" value="'.$row["Latitudine"].'"> ');
		        		echo('<input type="hidden" name="lng" value="'.$row["Longitudine"].'"> ');
		        		echo('<input type="hidden" name="foto" value="'.$row["foto"].'"> ');
		        		echo('<td><button name="info" value="">Info</button></td>');
		        		echo('</form></tr>'); 
		        	}

		        	// for ($row = 0; $row < count($res); $row++) { 
		         
		         // 	for ($col = 0; $col < count($res[$row]); $col++) {
		         
		         //  			echo "<td> ".$res[$row][$col]."</td>"; 
		         //   		}
		         // 	echo('</tr>'); 
		         
				
				?>
			  </tbody>
	        </table>
	      <!--</div>-->
	  <!--</div>-->
	</div>

	<div class="insert">

	 <div class="jumbotron jumbotron-fluid">
	  <div class="container" align="center">
	    <h1>Vuoi diventare una guida di viaggio?</h1>      
	    <p>Diventa un punto di riferimento per gli altri utenti, condividendo le tue esperienze e conoscenze della città in cui vivi. Lasciaci assaporare ogni angolo e  via, per un esperienza indimenticabile!</p>
	  </div>
	</div>
	  <div class="row">
      	<div class="col-sm-6" align="center">
      	 <h2 align="center">Inserisci un monumento</h2>
		 <form method="post" action="uploadMonumento.php" enctype="multipart/form-data">
		  <table align="center">
		   <tr>
			<td> <b class="ex1"> Nome attrattiva:   </b></td>
			<td><input type="text" name="nomeAttrattiva" placeholder="Attrattiva" required /></td>
		   </tr>
		   <tr>
		   <tr>
			<td> <b class="ex1"> Via:   </b></td>
			<td><input type="text" name="indirizzo" placeholder="Via dell'attrattiva" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> N°:   </b></td>
			<td><input type="text" name="numero" placeholder="Numero civico" required /></td>
		   </tr>
		   <tr>
	         <td> <b class="ex1"> Aggiungi una foto: </b></td>
	         <td><input type="file" name="file" id="file" required=""></td>
	       </tr> 
		   <tr>
			<td> <b class="ex1"> Descrizione:   </b></td>
			<td><input type="text" name="descrizione" placeholder="Descrizione" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Stato:   </b></td>
			<td>
			 <select name="stato" class="stato_monumento">
	         <option value ="Visitabile">Visitabile</option>
	         <option value ="Non visitabile">Non visitabile</option>
	         <option value ="Visitabile gratis">Visitabile gratis</option>
      		 </select>
      		</td>
		   </tr>
		  </table>
		  <button type="submit" name="insertMonumento" >Inserisci</button>
		 </form>
      	</div>

      	<div class="col-sm-6" align="center">
      	 <h2 align="center">Inserisci un'attività ricreativa</h2>
		 <form method="post" action="uploadRicreativa.php" enctype="multipart/form-data">
		  <table align="center">
		   <tr>
			<td> <b class="ex1"> Nome attrattiva:   </b></td>
			<td><input type="text" name="nomeAttrattiva" placeholder="Nome attrattiva" required /></td>
		   </tr>
		   <tr>
		   <tr>
			<td> <b class="ex1"> Via:   </b></td>
			<td><input type="text" name="indirizzo" placeholder="Via dell'attrattiva" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> N°:   </b></td>
			<td><input type="text" name="numero" placeholder="Numero civico" required /></td>
		   </tr>
		   <tr>
		   <tr>
	         <td> <b class="ex1"> Aggiungi una foto: </b></td>
	         <td><input type="file" name="file" id="file" required=""></td>
	       </tr> 
		   <tr>
			<td> <b class="ex1"> Prezzo (€):   </b></td>
			<td>
			 <select name="prezzo" class="scelta">
	         <option value="1" >1</option>
	         <option value="2" >2</option>
	         <option value="3" >3</option>
	         <option value="5" >5</option>
	         <option value="8" >8</option>
	         <option value="10" >10</option>
	         <option value="15" >15</option>
	         <option value="20" >20</option>
      		 </select>
      		</td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Orario apertura:   <br>(h:m:s)</b></td>
			<td>
			 <select name="orarioApertura" class="scelta">
	         <option value="07:30:00" >07:30:00</option>
	         <option value="08:00:00" >08:00:00</option>
	         <option value="08:30:00" >08:30:00</option>
	         <option value="09:00:00" >09:00:00</option>
	         <option value="09:30:00" >09:30:00</option>
	         <option value="10:00:00" >10:00:00</option>
	         <option value="10:30:00" >10:30:00</option>
	         <option value="11:00:00" >11:00:00</option>
      		 </select>
      		</td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Orario chiusura:   <br>(h:m:s)</b></td>
			<td>
			 <select name="orarioChiusura" class="scelta">
	         <option value="18:00:00" >18:00:00</option>
	         <option value="18:30:00" >18:30:00</option>
	         <option value="19:00:00" >19:00:00</option>
	         <option value="19:30:00" >19:30:00</option>
	         <option value="20:30:00" >20:30:00</option>
	         <option value="21:00:00" >21:00:00</option>
	         <option value="21:30:00" >21:30:00</option>
	         <option value="22:00:00" >22:00:00</option>
      		 </select>
      		</td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Giorno chiusura:   </b></td>
			<td>
			 <select name="giornoChiusura" class="scelta">
	         <option value="Lunedì" >Lunedì</option>
	         <option value="Martedì">Martedì</option>
	         <option value="Mercoledì">Mercoledì</option>
	         <option value="Giovedì">Giovedì</option>
	         <option value="Venerdì">Venerdì</option>
	         <option value="Sabato">Sabato</option>
	         <option value="Domenica">Domenica</option>
      		 </select>
      		</td>
		   </tr>
		  </table>
		  <button type="submit" name="insertRicreativa">Aggiungi</button>
		 </form>	
      	</div>
      </div>

	</div>

	<script>
	function myFunction() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[1];
	    if (td) {
	      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
	        tr[i].style.display = "";
	      } else {
	        tr[i].style.display = "none";
	      }
	    } 
	  }
	}
	</script>

<?php
	include("footer.php");
?>

</body>
</html>