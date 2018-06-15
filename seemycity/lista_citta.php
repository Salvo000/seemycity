<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

 include_once('city.php');
 $object = new City();
 $res = $object -> displayListaCitta();

?>
<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/lista_citta.css" type="text/css" />
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
	include 'menu.php';
?>
	<div class="container">
	  <!--<div class="row">-->
	        <div class="panel-heading" align="center">
	          <h4>
	            Lista delle città
	          </h4>
	        </div>
	        <div class="panel-content" align="center" >
	          <h4>
	            <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Cerca la città...">
	          </h4>
	        </div>
	        <table class="table table-fixed" id="myTable">
	          <thead>
			    <tr bgcolor="#f1f1f1">
			      <th scope="col">Città</th>
			      <th scope="col">Regione</th>
			      <th scope="col">Stato</th>
			    </tr>
			  </thead>
	          <tbody>
			    <?php for ($row = 0; $row < count($res); $row++) { ?>
		          <tr style="cursor:hand">
		          <?php for ($col = 0; $col < count($res[$row]); $col++) { ?>
		          	<td><?php echo " ".$res[$row][$col]." "; ?></td>
		          <?php } ?>
		          </tr>
		        <?php } ?>
			  </tbody>
	        </table>
	  <!--</div>-->
	</div>

	<div class="insert" align="center">

	 <div class="jumbotron jumbotron-fluid">
	  <div class="container" align="center">
	    <h1>Ammira le foto più belle</h1>      
	    <p>Inserisci i dati della tua città</p>
	  </div>
	 </div>
	    <h2 align="center">Gallery</h2>
		  <form method="post" action="foto_citta.php">
			<table align="center">
			  <tr>
			   <td> <b class="ex1"> Città:   </b></td>
			   <td><input type="text" name="citta" placeholder="Nome città" required /></td>
			  </tr>
			</table>
			 <button type="submit" name="vediGallery">Vedi</button>
		  </form>
    </div>

	<div class="insert">

	 <div class="jumbotron jumbotron-fluid">
	  <div class="container" align="center">
	    <h1>Condividilo con tutti ed aiutaci a crescere ! </h1>      
	    <p>Condividi le tue esperienze, lasciaci una foto di una città.</p>
	  </div>
	 </div>
	  <div class="container" align="center">
	  <!--<div class="row" align="center">-->
	    <h2 align="center">Inserisci una foto ad una città</h2>
		<form method="post" action="upload2.php" enctype="multipart/form-data">
		<table align="center">
		  <tr>
			<td> <b class="ex1"> Titolo:   </b></td>
			<td><input type="text" name="titolo" placeholder="es: tramonto" required /></td>
		  </tr>
		  <tr>
			<td> <b class="ex1"> Nome città:   </b></td>
			<td><input type="text" name="citta" placeholder="es: Bologna" required /></td>
		  </tr>
		  <tr>
		    <td> <b class="ex1"> Foto: </b></td>
		    <td><input type="file" name="file" required=""></td>
	      </tr>
		</table>
		<input type="submit" name="inserisciFoto" value="Inserisci">
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
	include 'footer.php';
?>
</body>
</html>