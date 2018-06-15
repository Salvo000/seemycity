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
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
	
<head>

	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="css/menu.css" type="text/css" />
  <link rel="stylesheet" href="css/home.css" type="text/css" />
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
	<?php
	include("menu.php");
	?>

	<div class="container-fluid">
  <?php 
    echo('<h3 class="ex2" align="center"> Ciao '.$_SESSION["uname"].'</h3');

  ?>
	  <p align="center">Benvenuto in See My City!</p>

	  <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette" align="center">
          <div class="col-md-7">
            <h2 class="featurette-heading">Cerca nuovi percorsi. <span class="text-muted">Scopri le città.</span></h2>
            <p class="lead">Ogni utente premium potrà inserire percorsi esclusivamente per propria città. Questo vincolo ti garantirà che il singolo percorso sia modellato nel migliore dei modi, per assicurarti un esperienza di visita il più dettagliata possibile.</p>
          </div>
          <div class="col-md-4">
            <a href="percorsi.php">
            <img class="featurette-image img-fluid mx-auto" src="https://image.flaticon.com/icons/svg/236/236999.svg" alt="Generic placeholder image" height="200" width="200">
            </a>
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette" align="center">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Recensisci le tue esperienze. <span class="text-muted">Commenta le attrattive.</span></h2>
            <p class="lead">SeeMyCity è una piattaforma che tiene molto conto dei pareri degli utenti. Aiuta gli altri utenti a capire quale attrattiva sia più bella e adatta a loro.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <a href="attrattive.php">
            <img class="featurette-image img-fluid mx-auto" src="https://image.flaticon.com/icons/svg/235/235296.svg" alt="Generic placeholder image" height="200" width="200">
            </a>
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette" align="center">
          <div class="col-md-7">
            <h2 class="featurette-heading">Visualizza le statistiche. <span class="text-muted">Scopri le varie classifiche.</span></h2>
            <p class="lead">Questa piattaforma, tramite accurati algoritmi di datamining, ti permette di sapere in tempo reale le attrattive più commentate oppure i percorsi aggiunti più frequentemente ai preferiti.</p>
          </div>
          <div class="col-md-5">
          <a href="dataMining.php">
            <img class="featurette-image img-fluid mx-auto" src="https://image.flaticon.com/icons/svg/290/290196.svg" alt="Generic placeholder image" height="200" width="200">
          </a>
          </div>
        </div>

        <hr class="featurette-divider">

        <h1 class="featurette-heading" align="center">Autori</h1>
        <div class="row featurette">
          <div class="col-md-6" align="center">
            <img src="https://image.flaticon.com/icons/svg/145/145842.svg" style="height: 200px; width: 200px;" class="avatar float-center">
            <h3 class="ex2"><span class="text-muted">Massimo Righi</span></h3>
            <p class="ex1"><span class="text-muted">Laureando alla facoltà di Informatica per il Management.</span></p>
          </div>
          <div class="col-md-6" align="center">
            <img src="https://image.flaticon.com/icons/svg/145/145843.svg" style="height: 200px; width: 200px;" class="avatar float-center">
            <h3 class="ex2"><span class="text-muted">Salvatore Fiorilla</span></h3>
            <p class="ex1"><span class="text-muted">Laureando alla facoltà di Informatica per il Management.</span></p>
          </div>
        </div>

        <hr class="featurette-divider">

	</div>
		
	<?php
		include("footer.php");
	?>
	</div>
</body>
</html>