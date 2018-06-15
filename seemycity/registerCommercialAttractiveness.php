<?php
  
 	if(!isset($_SESSION)) 
    { 
        session_start();
        echo "creo sessione regCommAttract ";
    } 
	print_r($_SESSION);
  include_once('user.php');

	if(isset($_POST['signup'])){
      

  		$NomeAttrattiva=$_POST['NomeAttrattiva'];
      $NomeAttrattiva = addslashes($NomeAttrattiva);
  		$via=$_POST['via'];
  		$numero=$_POST['numero'];
  		$sitoweb=$_POST['sitoweb'];
  		$telefono=$_POST['telefono'];
  		
  	//mi recupero tutte le altre variabili dalla sessione
      $nickname = $_SESSION["uname"];
      $password = $_SESSION["psswd"];
      $citta = $_SESSION["citta"];
      $tipo = $_SESSION["tipo"];
      $regione = $_SESSION["regione"];
      $stato = $_SESSION["stato"];
      /*
      $via = ucwords($via);             // HELLO WORLD!
      $via = ucwords(strtolower($via)); // Hello World!
      $add = 'Via '.$via.', '.$numero;

      // $address di esempio = 'Via Zamboni, 33, Bologna, BO, Italia';  
      $address = $add.', '.$citta.','.$regione.', '.$stato;
      $lat="";
      $lng="";
      */
      include("GeoCordinate.php");
      $lat = floatval($lat);
      $lng = floatval($lng);
      $latitudine = $lat;
      $longitudine = $lng;
      echo "$lat :".$lat;

      
      if(strlen($lat)>0  ){
        if ($latitudine != 0 && $longitudine != 0) {
        
          $file = $_FILES['file'];
          //print_r($file);
          $fileName = $_FILES['file']['name'];
          $fileTmpName = $_FILES['file']['tmp_name'];
          $fileSize = $_FILES['file']['size'];
          $fileError = $_FILES['file']['error'];
          $fileType = $_FILES['file']['type'];

          $fileExt = explode('.',$fileName);
          $fileActualExt = strtolower(end($fileExt));

          $allowed = array('jpg', 'jpeg', 'png', 'svg');
          if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
              if ($fileSize < 1000000) {
                $fileCode = uniqid('', true);
                $fileNameNew = $fileCode.".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                //move_uploaded_file($fileTmpName, $fileDestination);
                
                $object = new User();
                $risultato = $object -> insertCommercialAttractiveness($NomeAttrattiva,$citta,$add,$longitudine,$latitudine,$nickname,$password,$fileDestination,$telefono,$sitoweb);
                if($risultato == 1 ){ //entro nel sito
                  move_uploaded_file($fileTmpName, $fileDestination);
                  $log = $object->Login($nickname,$password);
                  if ($log == 1) {
                    header("Location: http://localhost:/Progetto_0.0.2/home.php");
                    die();
                  }else{
                    echo "[ERRORE] Credenziali errate ".$log;
                  }
                }else{
                  echo "[ERRORE] Impossibile inserire l'attività commerciale ";
                }
                
                //header("Location: lista_citta.php?uploadsuccess");
              }else{
                echo "File troppo grande!";
              }
            }else{
              echo "Errore nel caricamento del file!";
            }
          }else{
            echo "Non puoi inserire file di questo formato!";
          }
        }else{
            echo "Indirizzo errato, riprovare con un altro indirizzo.";
        }
       }else{
        echo "Last step ! try again ! ";
      }
    }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="../../../../favicon.ico">

    <title>SMC Registrazione</title>


    <!-- Bootstrap core CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

      <link rel="stylesheet" type="text/css" href="css/register.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
<body>
  <div id = "Header" align="center">
     <hr><h2 class="ex1"> REGISTRA LA TUA ATTIVITA COMMERCIALE </h2></hr>
  </div>
  <div id = "content" class="center">
    <form action='registerCommercialAttractiveness.php' method="post" enctype="multipart/form-data">
    <table align="center">
      <tr>
        <td> <b class="ex1"> NomeAttrattiva:  </b></td>
        <td><input type='text' name="NomeAttrattiva" id="NomeAttrattiva" placeholder="NomeAttrattiva" required></td>
      </tr>
      <tr>
        <td> <b class="ex1"> Città:  </b></td>
       <!--  <td>
            <input type='text' name="citta" id="citta" value = "Citta" required readonly>
        </td> -->
        <?php
              echo ('<td> <input type="text" name="citta" id="citta" value = "'.$_SESSION["citta"].'" required readonly> </td>' ); 
            ?>
      </tr>
      <tr>
        <td> <b class="ex1"> Via/le:  </b></td>
        <td><input type='text' name="via" id="via" placeholder="Es. Cesare battisti" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> N:  </b></td>
        <td><input type='text' name="numero" id="numero" placeholder="Es. 11" required><td>
      </tr>
      <tr>
        <td> <b class="ex1"> Telefono:  </b></td>
        <td><input type='text' name="telefono" id="telefono" placeholder="Es. 1234567890 " required><td>
      </tr>    
      <tr>
        <td> <b class="ex1"> SitoWeb:  </b></td>
        <td><input type='text' name="sitoweb" id="sitoweb" placeholder="esempio.it" required><td>
      </tr>
       <tr>
       <td> <b class="ex1"> Foto: </b></td>
         <td>
            <input type="file" name="file" id="file" required="">
          </td>
       </tr> 

    </table>  
        <input type='submit' name="signup" value='Sign up'></div>
    </form>     
  </div>
  
</body>
</html>
