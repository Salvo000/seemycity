<?php
if(!isset($_SESSION)) 
   { 
      session_start(); 
   }

include_once('statistica.php');
$object = new Statistica();
$res = $object -> ListaAttrattiveVotate();

$res2 = $object -> ListaPercorsiPreferiti();

$res3 = $object -> ListaUtentiPiuAttivi();


?>

<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/dataMining.css" type="text/css" />
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
	  <div class="panel-heading">
	    <h4 align="center">
	      Lista delle attrattive più popolari
	       <br> 
	    </h4>
	  </div>
	  <div class="panel-content">
	    <h4>
	      <input type="text" id="myInput1" onkeyup="myFunction1()" placeholder="Cerca l'attrattiva per città...">
	    </h4>
	  </div>
	    <table class="table table-fixed" id="myTable1">
	      <thead>
			<tr bgcolor="#f1f1f1">
			  <th scope="col">Attrattiva</th>
			  <th scope="col">Città</th>
			  <th scope="col">Voto medio</th>
			  <th scope="col">Numero di voti</th>
			</tr>
		  </thead>
	      <tbody>

	      	<?php
		        if (count($res) == 0) {
		        	echo "<h1> NON SONO ANCORA STATI POSTATI COMMENTI </h1>";
		        }
		      ?>

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

	<div class="container">
	  <div class="panel-heading">
	    <h4 align="center">
	      Lista dei percorsi più popolari
	       <br> 
	    </h4>
	  </div>
	  <div class="panel-content">
	    <h4>
	      <input type="text" id="myInput2" onkeyup="myFunction2()" placeholder="Cerca il percorso per città...">
	    </h4>
	  </div>
	    <table class="table table-fixed" id="myTable2">
	      <thead>
			<tr bgcolor="#f1f1f1">
			  <th scope="col">Codice percorso</th>
			  <th scope="col">Città</th>
			  <th scope="col">Numero di preferenze</th>
			</tr>
		  </thead>
	      <tbody>

	        <?php for ($row = 0; $row < count($res2); $row++) { ?>
		      <tr style="cursor:hand"> <!--onclick="document.location='percorso.php'"-->
		      <?php for ($col = 0; $col < count($res2[$row]); $col++) { ?>
		        <td><?php echo " ".$res2[$row][$col]." "; ?></td>
		      <?php } ?>
		      </tr>
		    <?php } ?>

		  </tbody>
	    </table>
	</div>
	<div class="container">
	  <div class="panel-heading">
	    <h4 align="center">
	      Lista utenti più attivi
	       <br> 
	    </h4>
	  </div>
	  <div class="panel-content">
	    <h4>
	      <input type="text" id="myInput3" onkeyup="myFunction3()" placeholder="Cerca l'utente...">
	    </h4>
	  </div>
	    <table class="table table-fixed" id="myTable3">
	      <thead>
			<tr bgcolor="#f1f1f1">
			  <th scope="col">Utente</th>
			  <th scope="col">Attrattive inserite</th>
			  <th scope="col">Percorsi inseriti</th>
			  <th scope="col">Totale inserimenti</th>
			</tr>
		  </thead>
	      <tbody>

	        <?php for ($row = 0; $row < count($res3); $row++) { ?>
		      <tr style="cursor:hand"> <!--onclick="document.location='percorso.php'"-->
		      <?php for ($col = 0; $col < count($res3[$row]); $col++) { ?>
		        <td><?php echo " ".$res3[$row][$col]." "; ?></td>
		      <?php } ?>
		      </tr>
		    <?php } ?>

		  </tbody>
	    </table>
	</div>

	<script>
	function myFunction1() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput1");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable1");
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
	<script>
	function myFunction2() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput2");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable2");
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
	<script>
	function myFunction3() {
	  // Declare variables 
	  var input, filter, table, tr, td, i;
	  input = document.getElementById("myInput3");
	  filter = input.value.toUpperCase();
	  table = document.getElementById("myTable3");
	  tr = table.getElementsByTagName("tr");

	  // Loop through all table rows, and hide those who don't match the search query
	  for (i = 0; i < tr.length; i++) {
	    td = tr[i].getElementsByTagName("td")[0];
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