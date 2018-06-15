<?php


include_once('connection.php');

if(!isset($_SESSION)){ 
    session_start(); 
}

/**
* 
*/
class Attraction
{
	
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}

	public function insertMonumento($nomeAttrattiva, $nomeCitta, $indirizzo, $longitudine, $latitudine, $nicknameUtente, $foto, $descrizione, $stato){
		
		try{
		$nomeAttrattiva = addslashes($nomeAttrattiva);
		$nomeCitta = addslashes($nomeCitta);
		$descrizione = addslashes($descrizione);
		// echo"CALL InsertMonumento('$nomeAttrattiva','$nomeCitta','$indirizzo','$longitudine','$latitudine','$nicknameUtente','$foto','$descrizione','$stato',@res)";
		$query_insertMonumento = $this -> db -> prepare("CALL InsertMonumento('$nomeAttrattiva','$nomeCitta','$indirizzo','$longitudine','$latitudine','$nicknameUtente','$foto','$descrizione','$stato',@res)");
		$query_insertMonumento -> execute();
		$query_insertMonumento->closeCursor();

		$query_select_insertMonumento = $this -> db -> prepare("SELECT @res");
		$query_select_insertMonumento -> execute();
		$result = $query_select_insertMonumento -> fetch();
		$query_select_insertMonumento->closeCursor();

		$risultato = $result['@res'];
		}catch (PDOException $e) {
			return"[Errore] InsertMonumento non andato a buon fine ".$e->getMessage();
		}
		return $risultato;
	}

	public function insertAttivitaRicreativa($nomeAttrattiva, $nomeCitta, $indirizzo, $longitudine, $latitudine, $nicknameUtente, $foto, $prezzo, $orarioApertura, $orarioChiusura, $giornoChiusura){

		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$nomeCitta = addslashes($nomeCitta);
			$query_insertRicreativa = $this -> db -> prepare("CALL InsertAttivitaRicreativa('$nomeAttrattiva','$nomeCitta','$indirizzo','$longitudine','$latitudine','$nicknameUtente','$foto','$prezzo','$orarioApertura','$orarioChiusura','$giornoChiusura',@res)");
			$query_insertRicreativa -> execute();
			$query_insertRicreativa->closeCursor();

			$query_select_insertRicreativa = $this -> db -> prepare("SELECT @res");
			$query_select_insertRicreativa -> execute();
			$result = $query_select_insertRicreativa -> fetch();
			$query_select_insertRicreativa->closeCursor();
			
			$risultato = $result['@res'];

		}catch (PDOException $e) {
			return "[Errore] InsertAttivitaRicreativa non andato a buon fine ".$e->getMessage();
		}
		/*
		if ($risultato == 1) {
			echo "Attrattiva aggiunta";
		}else{
			echo "[ERRORE] Impossibile aggiungere l'attrattiva";
		}
		*/

		return $risultato;
	}

	public function insertAttivitaCommerciale($nomeAttrattiva, $nomeCitta, $indirizzo, $longitudine, $latitudine, $nicknameUtente, $foto, $telefono, $sitoWeb){
		
		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$nomeCitta = addslashes($nomeCitta);
			$query_insertCommerciale = $this -> db -> prepare("CALL InsertAttivitaCommerciale('$nomeAttrattiva','$nomeCitta','$indirizzo','$longitudine','$latitudine','$nicknameUtente','$foto','$telefono','$sitoWeb',@res)");
			$query_insertCommerciale -> execute();
			$query_insertCommerciale->closeCursor();

			$query_select_insertCommerciale = $this -> db -> prepare("SELECT @res");
			$query_select_insertCommerciale -> execute();
			$result = $query_select_insertCommerciale -> fetch();
			$query_select_insertCommerciale->closeCursor();

			$risultato = $result['@res'];

		}catch (PDOException $e) {
			echo"[Errore] InsertAttivitaCommerciale non andato a buon fine ".$e->getMessage();
		}
		if ($risultato == 1) {
			echo "Attrattiva aggiunta";
		}else{
			echo "[ERRORE] Impossibile aggiungere l'attrattiva";
		}
	}

	public function insertComment($recensione, $votazione, $tempoVisita, $giornoVisita, $nomeAttrattiva, $nomeCitta, $nicknameUtente){

		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$nomeCitta = addslashes($nomeCitta);
			$recensione = addslashes($recensione);
			$query_insertComment = $this -> db -> prepare("CALL InsertComment('$recensione','$votazione','$tempoVisita','$giornoVisita','$nomeAttrattiva','$nomeCitta','$nicknameUtente',@res)");
			$query_insertComment -> execute();
			$query_insertComment->closeCursor();

			$query_select_insertComment = $this -> db -> prepare("SELECT @res");
			$query_select_insertComment -> execute();
			$result = $query_select_insertComment -> fetch();
			$query_select_insertComment->closeCursor();

			$risultato = $result['@res'];
		
		}catch (PDOException $e) {
			echo"[Errore] insertComment non andato a buon fine ".$e->getMessage();
		}

		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Commento inserito');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Impossibile inserire il commento');</script>";
		}
	}

	public function displayListaAttrattive(){
		try{
			$sql = "SELECT * FROM Attrattiva";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		
  		return $res;

	}


	public function getCommentiAttrattiva($nomeAttrattiva, $citta){

		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$citta = addslashes($citta);
			$sql = ("select * from Commento where (Commento.NomeAttrattiva='$nomeAttrattiva' and Commento.NomeCitta='$citta') order by id "); 
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}

		return $res;

	}

	public function addComment($recensione, $votazione, $tempoVisita, $giornoVisita, $nomeAttrattiva,$citta,$nickname){
		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$citta = addslashes($citta);
			$recensione = addslashes($recensione);
			$query_addComment = $this -> db -> prepare("CALL InsertComment('$recensione','$votazione','$tempoVisita','$giornoVisita','$nomeAttrattiva','$citta','$nickname',@res) ");
			$query_addComment -> execute();
			$query_addComment->closeCursor();

			$query_select_addComment = $this -> db -> prepare("SELECT @res");
			$query_select_addComment -> execute();
			$result = $query_select_addComment -> fetch();
			$query_select_addComment->closeCursor();

			$risultato = $result['@res'];

		}catch (PDOException $e) {
			echo"[Errore] addComment non andato a buon fine ".$e->getMessage();
		}
		
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Commento inserito con successo');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Impossibile inserire commento');</script>";
		}

	}
	
	/*

dato l'attrattiva torna il numero di visite per giorno ricevute
dayofweek(date) ritora un valore da 1 a 7 

1.Sunday = domenica
2.Monday = lunedì 
3.Tuesday = martedí
4.Wednesday = mercoledí
5.Thursday = glovedì
6.Friday = venerdì
7.Saturday = sabato */

	public function getDayVisitors($nomeAttrattiva, $cittaAttrattiva){

		try{
		$nomeAttrattiva = addslashes($nomeAttrattiva);
		$cittaAttrattiva = addslashes($cittaAttrattiva);
		$sql =("select DayWeek ,sum(NumVisitorsToTime) as VisiteGiornaliere from tab as t where Nome='".$nomeAttrattiva."' and Citta= '".$cittaAttrattiva."' group by DayWeek"); 
		
		$res=$this -> db ->query($sql);
		
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}

		return $res;

	}
	

	/* dato il giorno torna il gli orari con affluenza massima */

	public function getHoursVisitors($nomeAttrattiva, $cittaAttrattiva, $giorno){
  
	  try{
	  	$nomeAttrattiva = addslashes($nomeAttrattiva);
	  	$cittaAttrattiva = addslashes($cittaAttrattiva);
	   /*
	  
	   select TempoVisita from tab where nome = "Chiesa San Tomaso" and Citta = "Milano" and Dayweek =7 and NumVisitorsToTime = (select max(NumVisitorsToTime) from tab where  nome = "Chiesa San Tomaso" and Citta = "Milano" and Dayweek =7)
	   */
	  $sql = ("select TempoVisita from tab where nome ='".$nomeAttrattiva."' and Citta = '".$cittaAttrattiva."' and Dayweek =".$giorno." and NumVisitorsToTime = (select max(NumVisitorsToTime) from tab where  nome = '".$nomeAttrattiva."' and Citta = '".$cittaAttrattiva."' and Dayweek =".$giorno.") limit 1");
	  
	  $res=$this -> db ->query($sql);
	  
	  }catch(PDOException $e) {
	      echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
	      // exit();
	    }

	  return $res;

	}


}






?>