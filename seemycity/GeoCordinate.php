<?php  


	//Example:::: $address = 'Via Zamboni, 33, Bologna, BO, Italia'; :::::
	
	$via = ucwords($via);             // HELLO WORLD!
    $via = ucwords(strtolower($via)); // Hello World!
    
    $add = 'Via '.$via;
    if($numero > 0){
        $add = $add.', '.$numero;    
    }
    
    // $address di esempio = 'Via Zamboni, 33, Bologna, BO, Italia';  
    $lat=0.0;
    $lng=0.0;
	$address = $add.', '.$citta.','.$regione.', '.$stato;

	if(strcmp(substr($address,4,3), "Via") == '0'){
		$address = substr($address, 4);
	}

    if(strcmp(substr($address, 4,6), "Piazza") == '0'){
		$address = substr($address, 4); //Piazza Malpighi;
	}


	if(strcmp(substr($add,4,3), "Via") == '0'){
		$add = substr($add, 4);
	}

    if(strcmp(substr($add, 4,6), "Piazza") == '0'){
		$add = substr($add, 4); //Piazza Malpighi;
	}


	$encoding_address = urlencode($address);  
	$GoogleAPI = 'http://maps.google.com/maps/api/geocode/xml?address='.$encoding_address.'&sensor=false';  

	// echo("$GoogleAPI");


	
	for($i=1; $i<100 && $i>0;$i++){

	    $XMLresult = file_get_contents($GoogleAPI);  
	    $XMLobject = new SimpleXMLElement($XMLresult);  
	    if($XMLobject->status=='OK'){  
	    // echo 'Latitude: '. $XMLobject->result->geometry->location->lat;  
	    // echo '<br />Longigude: '.$XMLobject->result->geometry->location->lng;  
	        $lat = floatval($XMLobject->result->geometry->location->lat);
	        $lng = floatval($XMLobject->result->geometry->location->lng);
	        $i = -2;
	    }
	        echo($i);
	}

	if($i>0){     
	    $message = "Sorry address : $address not found, try again please, we need the follow patter \nVia: Nome della via \n";
	    echo '<script> alert.($message);</script>';  
	}
	    





?>  