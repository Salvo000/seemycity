<?php
	echo "Sono dentro";
   if(isset($_POST['utente'])) {
    $utente = $_POST['utente'];
    echo "ciao".$utente." !";
}

?>