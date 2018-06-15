<?php
 if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
include_once('city.php');

if (isset($_POST['inserisciFoto'])) {

	$titolo = $_POST['titolo'];
	$citta = $_POST['citta'];

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

 				$object = new City();
				$object -> insertFoto($fileCode, $titolo, $citta, $fileDestination);


 				move_uploaded_file($fileTmpName, $fileDestination);
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
 }





?>