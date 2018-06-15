<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

 include_once('path.php');
 $object = new Path();
 
 if(isset($_POST['eliminaPreferito'])){

	$codice = $_POST['codice'];

	$object = new Path();
	$object -> deleteFavoritePath($_SESSION["uname"], $codice);
 }
 $res = $object -> displayListaPreferiti($_SESSION['uname']);
 ?>

<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/preferiti.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


    <meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">
</head>
<body>

<?php
	include('menu.php');
?>
<div class="content">
	<div class="row">
		<div class="container" align="center">
		  <h2 align="center">Preferiti</h2>
		  <p align="center">Lista dei percorsi preferiti</p>            
		  <table class="table table-condensed" id="myTable">
		    <thead>
		      <tr>
		        <th>Nickname Utente</th>
		        <th>Nome percorso</th>
		        <th>Note</th>
		      </tr>
		    </thead>
		    <tbody>
		      <?php
		        if (count($res) == 0) {
		        	echo "<h1> NON CI SONO PERCORSI </h1>";
		        }
		      ?>
		      <?php for ($row = 0; $row < count($res); $row++) { ?>
			    <tr style="cursor:hand">
			      <?php for ($col = 0; $col < count($res[$row]); $col++) { ?>
			        <td><?php echo " ".$res[$row][$col]." "; ?></td>
			      <?php } 
			      	echo("<td>");
			      	echo('<form method="post" action="preferiti.php">');
					echo('<input type="hidden" name="codice" value="'.$res[$row][$col-2].'"/>');
			      	echo('<button type="submit" name="eliminaPreferito"><span class="glyphicon glyphicon-plus"></span> Elimina</button>');
			      	echo('</form>');
			      	echo("</td>");
			      ?>
			    </tr>
			  <?php } ?>
		    </tbody>
		  </table>
		</div>
	</div>
	<!--
	<div class="row">
      	<div class="container" align="center">
      	 <h2 align="center">Cancella un percorso preferito</h2>
		 <form method="post" action="preferiti.php"">
		  <table align="center">
		   <tr>
			<td> <b class="ex1"> Codice percorso:   </b></td>
			<td><input type="text" name="codice" placeholder="Codice percorso" required /></td>
		   </tr>
		  </table>
		  <button type="submit" name="eliminaPreferito">
		   <span class="glyphicon glyphicon-plus"></span> Elimina
		  </button>
		 </form>
      	</div>
	-->
<p id="demo"></p>
<?php
	include('footer.php');
?>
</div>


<script>

$(document).ready(function(){
    $("button.delete").click(function(){
        $.ajax({url: "eliminaPreferiti.php",
        	data: {'utente': utente},
         	type: 'post', 
        	success: function(result){
            	$("#div1").html(result);
        }});
    });
});
</script>


</body>
</html>
