<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

 include_once('user.php');
 $object = new User();
 $res = $object -> displayListaUtentiIndex();

if(isset($_POST['eliminaUtente'])){
 	$object = new User();
 	$password = $_POST['passwordDisattiva'];
	$display = $object -> deleteUtente($_SESSION['uname'], $password);
}

 if(isset($_POST['logoutUtente'])){

 	$_SESSION["uname"] = null;
   	$_SESSION["psswd"] = null;
   	$_SESSION["citta"] = null;
   	$_SESSION["tipo"] = null;
   	$_SESSION["email"] = null;
   	$_SESSION["datan"] = null;
   	$_SESSION["regione"] = null;
   	$_SESSION["stato"] = null;
	header("Location: http://localhost/Progetto_0.0.2/index.php");


 }
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/profilo.css" type="text/css" />
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
		  <h2 align="center">Utenti</h2>
		  <p align="center">Lista degli utenti attivi nella piattaforma</p>            
		  <table class="table table-condensed" id="myTable">
		    <thead>
		      <tr>
		        <th>Nickname</th>
		        <th>Email</th>
		        <th>Data di nascita</th>
		        <th>Città residenza</th>
		        <th>Tipo<th>
		      </tr>
		    </thead>
		    <tbody>
		      <?php
		        if (count($res) == 0) {
		        	echo "<h1> NON CI SONO UTENTI </h1>";
		        }
		      ?>
		      <?php for ($row = 0; $row < count($res); $row++) { ?>
			    <tr style="cursor:hand">
			      <?php for ($col = 0; $col < count($res[$row]); $col++) { ?>
			        <td><?php echo " ".$res[$row][$col]." "; ?></td>
			      <?php } ?>
			    </tr>
			  <?php } ?>
		    </tbody>
		  </table>
		</div>
	</div>

    <hr class="featurette-divider">

	<div class="row featurette">
	  <div class="col-sm-6" align="center">
      	<div class="container" align="center">
      	 <h2 align="center">Disattiva il tuo profilo</h2>
		 <form method="post" action="profilo.php"">
		 <table align="center">
		   <tr>
			<td> <b class="ex1"> Password:   </b></td>
			<td><input type="password" name="passwordDisattiva" placeholder="********" required /></td>
		   </tr>
		  </table>
		  <button type="submit" name="eliminaUtente">Disattiva</button>
		 </form>
      	</div>
      </div>
      <div class="col-sm-6" align="center">
      	<div class="container" align="center">
      	 <h2 align="center">Esci da SeeMyCity</h2>
		 <form method="post" action="profilo.php"">
		  <button type="submit" name="logoutUtente">Logout</button>
		 </form>
      	</div>
      </div>
    </div>

<p id="demo"></p>
<?php
	include('footer.php');
?>
</div>