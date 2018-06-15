<!-- <!-- Per eseguire lo script in PHP dovrete aver installato curl sul vostro server e dovrete averlo abilitato per essere utilizzato da PHP. 
Ovviamente se si hanno tanti indirizzi da geocodificare bisognerà andarli a prendere dal database e successivamente bisognerà andare a memorizzare longitudine e latitudine associati a ciascun record ma ho omesso questa parte perchè banale e perchè le possibilità sono davvero molteplici (dal file di testo a quello XML al più comune database in SQL -->


<?php
// 	//key api google presa su https://developers.google.com/maps/documentation/javascript/get-api-key
// 	$key = AIzaSyB0YRwZoZHgqg7hMRgE2Xt1WkXKgMvg0QA;
// //Set up our variables
// $longitude = "";
// $latitude = "";
// $precision = "";
// //Three parts to the querystring: q is address, output is the format (
// 	$address_to_encode="via Durini, 24 20122 Milano"
// 	$address = urlencode($address_to_encode);
// 	$url = "http://maps.google.com/maps/geo?q=".$address."&output=csv&key=".$key;

// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL, $url);
// 	curl_setopt($ch, CURLOPT_HEADER,0);
// 	curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
// 	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	$data = curl_exec($ch);
// 	curl_close($ch);
// 	//echo "Data: ". $data."";
// 	if (strstr($data,'200')){
// 		$data = explode(",",$data);
// 		$precision = $data[1];
// 		$latitude = $data[2];
// 		$longitude = $data[3];
// 		echo "n: ".$count." Latitude: ".$latitude."";
// 		echo " Longitude: ".$longitude."\r\n";
// 	} else {
// 		echo "Error in geocoding!";
// 	} ?> -->

<!-- <!doctype html>  
<html>  
<head>  
    <title>Get latitude and longitude with Jquery and Google Maps</title>  
    <!-- INCLUSIONE DELLE LIBRERIE NECESSARIE -->   
    <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>   
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&region=IT"></script>   
    <script>  
    $(document).ready(function() {  
        $("#GetMaps").click(function(){  
            var input_address = $("#address").val();  
            var geocoder = new google.maps.Geocoder();  
            geocoder.geocode( { address: input_address }, function(results, status) {  
                if (status == google.maps.GeocoderStatus.OK) {  
                    var lat = results[0].geometry.location.lat();  
                    var lng = results[0].geometry.location.lng();  
                    alert(lat + ' ' + lng);  
                    }  
                else {  
                    alert("Google Maps not found address!");  
                    }  
                });  
        });  
    });  
    </script>  
</head>  
<body>  
<form>  
	<label for="address">Address*</label>  
	
	 --><!-- INPUT CON ID ADDRESS IN CUI L'UTENTE INSERIRIRA' L'INDIRIZZO -->  
	<!-- <input type="text" name="address" id="address" />  
  
</form>  
   -->
<!-- UN LINK AL CUI CLICK EFFETTUEREMO LA RICHIESTA -->     
<!-- <a href="#" id="GetMaps">Set maps</a>  
  
</body>  
</html>   -->
