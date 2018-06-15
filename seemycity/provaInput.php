<?php

include_once('user.php');


//La parte da cambiare quando mi serve la lista degli eventi, o degli utenti, o dei messaggi è solamente queste due righe.
$object = new User();
$res = $object -> displayListaMessaggiPrivati('snorlax');

for ($row = 0; $row < count($res); $row++) {
	for ($col = 0; $col < count($res[$row]); $col++) {
	    echo " ".$res[$row][$col]." ";
	}
	echo "<br>";
}

?>