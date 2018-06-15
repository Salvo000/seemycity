<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

 include_once('path.php');
 $object = new Path();
 

 if(isset($_POST['inserisciPercorso'])){

	$codice = $_POST['codice'];
	$nome = $_POST['nome'];
	$durata = $_POST['durataPercorso'];
	$categoria = $_POST['categoriaPercorso'];
	$nomeCitta = $_SESSION['citta'];


	$object = new Path();
	$object -> insertPath($codice, $durata, $nome, $categoria, $nomeCitta, $_SESSION["uname"]);

	// $_SESSION["uname"] = $nickname;
	// $_SESSION["psswd"] = $password;
 }

 if(isset($_POST['inserisciAttrattivaPercorso'])){

	$attrattiva = $_POST['nomeAttrattiva'];
	$citta = $_SESSION['citta'];
	$codice = $_POST['codice'];
	$visita = $_POST['visita'];


	$object = new Path();
	$object -> insertAttrattivaInPath($attrattiva, $citta, $codice, $visita, $_SESSION["uname"]);

	// $_SESSION["uname"] = $nickname;
	// $_SESSION["psswd"] = $password;
 }
 $res = $object -> displayListaPercorsi();
 
 if(isset($_POST['vediPercorso'])){

	$codice = $_POST['codice'];
	echo($codice);
	$object = new Path();
	$risposta = $object -> viewPercorso($codice);
	echo($risposta);

	// $_SESSION["uname"] = $nickname;
	// $_SESSION["psswd"] = $password;
 }
?>
<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/percorsi.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />

	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

	<!--<link rel="stylesheet" type="text/css" href="menu.css">-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">
</head>
<body>
	<?php
		include('menu.php');
	?>
	<div class="container">
	  <!--<div class="row">-->
	      <!--<div class="panel panel-default">-->
	        <div class="panel-heading">
	          <h4>
	            Lista dei percorsi
	            <br> 
	          </h4>
	        </div>
	        <div class="panel-content">
	          <h4>
	            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cerca il percorso per città...">
	          </h4>
	        </div>
	        <table class="table table-fixed" id="myTable">
	          <thead>
			    <tr bgcolor="#f1f1f1">
			      <th scope="col">Codice</th>
			      <th scope="col">Durata(h)</th>
			      <th scope="col">Nome</th>
			      <th scope="col">Categoria</th>
			      <th scope="col">Città</th>
			      <th scope="col">Utente</th>
			    </tr>
			  </thead>
	          <tbody>

	          	<?php for ($row = 0; $row < count($res); $row++) { ?>
		          <tr style="cursor:hand"> <!--onclick="document.location='percorso.php'"-->
		          <?php for ($col = 0; $col < count($res[$row]); $col++) { ?>
		          	<td><?php echo " ".$res[$row][$col]." "; ?></td>
		          <?php } ?>
		          </tr>
		        <?php } ?>

			  </tbody>
	        </table>
	  </div>
	  <div class="row">
      	<div class="container" align="center">
      	 <h2 align="center">Vedi nello specifico un percorso</h2>
		 <form method="post" action="percorsi.php">
		  <table align="center">
		   <tr>
			<td> <b class="ex1"> Codice percorso:   </b></td>
			<td><input type="text" name="codice" placeholder="Codice percorso" required /></td>
		   </tr>
		  </table>
		  <button type="submit" name="vediPercorso">Vedi</button>
		 </form>
      	</div>
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
      	 <h2 align="center">Inserisci nuovo percorso</h2>
		 <form method="post" action="percorsi.php">
		  <table align="center">
		   <tr>
			<td> <b class="ex1"> Codice:   </b></td>
			<td><input type="text" name="codice" placeholder="Codice percorso" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Titolo:   </b></td>
			<td><input type="text" name="nome" placeholder="Nome" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Durata:   <br>(h:m:s)</b></td>
			<td>
			 <select class="durata_percorso" name="durataPercorso">
	         <option value="00:30:00">00:30:00</option>
	         <option value="01:00:00">01:00:00</option>
	         <option value="01:30:00">01:30:00</option>
	         <option value="02:00:00">02:00:00</option>
	         <option value="02:30:00">02:30:00</option>
	         <option value="03:00:00">03:00:00</option>
	         <option value="04:00:00">04:00:00</option>
      		 </select>
      		</td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Categoria:   </b></td>
			<td>
			 <select class="categoria_percorso" name="categoriaPercorso">
	         <option value="Arte">Arte</option>
	         <option value="Storia">Storia</option>
	         <option value="Natura">Natura</option>
	         <option value="Gastronomico">Gastronomico</option>
	         <option value="Relax">Relax</option>
	         <option value="Misto">Misto</option>
      		 </select>
      		</td>
		   </tr>
		  </table>
		  <button type="submit" name="inserisciPercorso">
		   <span class="glyphicon glyphicon-plus"></span> Inserisci
		  </button>
		 </form>
      	</div>

      	<div class="col-sm-6" align="center">
      	 <h2 align="center">Aggiungi attrattiva a percorso</h2>
		 <form method="post" action="percorsi.php"">
		  <table align="center">
		   <tr>
			<td> <b class="ex1"> Nome attrattiva:   </b></td>
			<td><input type="text" name="nomeAttrattiva" placeholder="Nome attrattiva" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Codice percorso:   </b></td>
			<td><input type="text" name="codice" placeholder="Codice percorso" required /></td>
		   </tr>
		   <tr>
			<td> <b class="ex1"> Durata visita:   <br>(h:m:s)</b></td>
			<td>
			 <select class="durata_attrattiva" name="visita">
	         <option value="00:10:00">00:10:00</option>
	         <option value="00:15:00">00:15:00</option>
	         <option value="00:20:00">00:20:00</option>
	         <option value="00:30:00">00:30:00</option>
	         <option value="01:00:00">01:00:00</option>
	         <option value="01:15:00">01:15:00</option>
	         <option value="01:30:00">01:30:00</option>
	         <option value="02:00:00">02:00:00</option>
      		 </select>
      		</td>
		   </tr>
		  </table>
		  <button type="submit" name="inserisciAttrattivaPercorso">Aggiungi</button>
		 </form>	
      	</div>
      </div>
    <?php
		include('footer.php');
	?>
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
	    td = tr[i].getElementsByTagName("td")[4];
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