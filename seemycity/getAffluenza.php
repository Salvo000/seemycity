<div class="container" >
<?php
  		$res_affluenza_per_giorno = $object->getDayVisitors($_SESSION["nomeAttrattiva"],$_SESSION["cittaAttrattiva"]);


  		$array = array();
  		
  		for($j=1;$j<8;$j++){
  			$array[$j] = 0;
		}
		
		while ($row = $res_affluenza_per_giorno->fetch()) {
			$array[$row["DayWeek"]]= $row["VisiteGiornaliere"];
		}
		
		// echo('<TABLE class="table table-condensed" CELLPADDING="5" CELLSPACING="0">');
		echo('<TABLE CELLPADDING="5" CELLSPACING="0">');
 			echo "<tbody>";
 		echo('<TR VALIGN="bottom">');
  		echo('<TH ROWSPAN="3" VALIGN="middle">Accessi<BR>giornalieri<br>stimati</TH>');
 	  		echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[1].'"></TD>');
 	  		echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[2].'"></TD>');
	  echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[3].'"></TD>');
	  echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[4].'"></TD>');
	  echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[5].'"></TD>');
	   echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[6].'"></TD>');
	   echo('<TD><IMG SRC="img/head.png" WIDTH="30" HEIGHT="'.$array[7].'"></TD>');
	  echo'</TR>';
	  echo'<TR>';
	   echo'<TD>'.$array[1].'</TD><TD>'.$array[2].'</TD><TD>'.$array[3].'</TD><TD>'.$array[4].'</TD><TD>'.$array[5].'</TD><TD>'.$array[6].'</TD><TD>'.$array[7].'</TD>';
	  echo'</TR>';
	  echo'<TR>';
	   echo'<TD>dom</TD><TD>lun</TD><TD>mar</TD><TD>mer</TD><TD>gio</TD><TD>ven</TD><TD>sab</TD>';
	  echo'</TR>';
	
		$array = array();
  		
  		for($j=1;$j<8;$j++){
  			$array[$j] = "00:00";

  			$res_affluenza_per_ora = $object->getHoursVisitors($_SESSION["nomeAttrattiva"],$_SESSION["cittaAttrattiva"],$j);
  			$row = $res_affluenza_per_ora->fetch();
  			
  			if(isset($row["TempoVisita"])){
  				$array[$j]=$row["TempoVisita"];
  				//$array[$j] = substr($array[$j], 0,5);
  			}
		}

	  echo'<TH VALIGN="middle">Ore più affollate <BR>giornaliere<br>stimati</TH>';
	   echo'<TD>'.$array[1].'</TD><TD>'.$array[2].'</TD><TD>'.$array[3].'</TD><TD>'.$array[4].'</TD><TD>'.$array[5].'</TD><TD>'.$array[6].'</TD><TD>'.$array[7].'</TD>';
	   echo "</tbody>";
	 echo'</TABLE>';

?>
</div>



