<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
include_once('attraction.php');

if(isset($_POST["insertMonumento"])){
 		
 	$nomeAttrattiva1 = $_POST["nomeAttrattiva"];
    $nomeAttrattiva = addslashes($nomeAttrattiva1);
 	$citta = $_SESSION["citta"];
 	$regione = $_SESSION["regione"];
    $stato = $_SESSION["stato"];	//$_POST["citta"];
 	$via = $_POST["indirizzo"];
 	$numero=$_POST['numero'];
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

 	$nicknameUtente= $_SESSION["uname"];
 	$descrizione1 = $_POST["descrizione"];
    $descrizione = addslashes($descrizione1);
 	$stato= $_POST["stato"];

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

         				$object = new Attraction();
        				$ris = $object->insertMonumento($nomeAttrattiva, $citta, $add, $longitudine, $latitudine, $nicknameUtente, $fileDestination, $descrizione, $stato);

                        if ($ris == 1) {
                            move_uploaded_file($fileTmpName, $fileDestination);
                        }else{
                            echo "Impossibile inserire il monumento";
                            exit();
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