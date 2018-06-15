<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

 include_once('city.php');
 $object = new City();
 if (isset($_POST['vediGallery'])) {
 	$citta = $_POST['citta'];
 }
 $res = $object -> displayListaFotoCitta($citta);
?>

<!DOCTYPE html>
<html>
<head>
	<title>SeeMyCity</title>
	<link rel="stylesheet" href="css/foto_citta.css" type="text/css" />
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
		include"menu.php";

	?>

	<h3 text-align="center" >Questa gallery è anche merito tuo, a te la nostra collezione di foto su <?php echo$citta; ?> </h3>
		<?php
		if (count($res) == 0) {
		    echo "<h1> NON CI SONO FOTO PER QUESTA CITTA' </h1>";
		}
	?>
	<?php for ($row = 0; $row < count($res); $row++) { ?>
		<div class="gallery">
		  <a target="_blank" href=<?php echo " ".$res[$row][0]." "; ?>>
		    <img src=<?php echo " ".$res[$row][0]." "; ?> width="300" height="200">
		  </a>
		  <div class="desc"><?php echo " ".$res[$row][1]." "; ?></div>
		</div>
	<?php } ?>

	<!--<div class="gallery">
	  <a target="_blank" href="img_forest.jpg">
	    <img src="img_forest.jpg" alt="Forest" width="600" height="400">
	  </a>
	  <div class="desc">Add a description of the image here</div>
	</div>-->
	<?php
	include"footer.php";
	?>
</body>
</html>