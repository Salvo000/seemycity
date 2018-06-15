<?php

include_once('connection.php');

if(!isset($_SESSION)){ 
    session_start(); 
}

/**
* 
*/
class Event
{
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}
	public function AddEvent($titolo, $descrizione, $data, $orarioInizio, $capienzaMax, $stato, $attivitaCommerciale, $nomeCitta, $nicknameUtente){
		try{
			$titolo = addslashes($titolo);
			$descrizione = addslashes($descrizione);
			$attivitaCommerciale = addslashes($attivitaCommerciale);
			$nomeCitta = addslashes($nomeCitta);
			$query_addEvent = $this -> db -> prepare("CALL AddEvent('$titolo','$descrizione','$data','$orarioInizio','$capienzaMax','$stato','$attivitaCommerciale','$nomeCitta','$nicknameUtente',@res)");
			
			$query_addEvent -> execute();
			$query_addEvent->closeCursor();

			$query_select_addEvent = $this -> db -> prepare("SELECT @res");
			$query_select_addEvent -> execute();
			$result = $query_select_addEvent -> fetch();
			$query_select_addEvent->closeCursor();

			$risultato = $result['@res'];
		}catch (PDOException $e) {
			echo"[Errore] AddEvent non andato a buon fine ".$e->getMessage();
		}

		if ($risultato == 1) {
			echo "Evento inserito con successo";
			echo "<script type='text/javascript'>alert('Evento inserito con successo');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] AddEvent non funziona');</script>";
			echo "[ERRORE] AddEvent non funziona";
		}
	}

	public function followEvent($nicknameUtente, $titoloEvento){
		

		// echo("CALL FollowEvent('$nicknameUtente','$titoloEvento',@res)");
		try{
			$titoloEvento = addslashes($titoloEvento);
			$query_followEvent = $this -> db -> prepare("CALL FollowEvent('$nicknameUtente','$titoloEvento',@res)");
			$query_followEvent -> execute();
			$query_followEvent->closeCursor();

			$query_select_followEvent = $this -> db -> prepare("SELECT @res");
			$query_select_followEvent -> execute();
			$result = $query_select_followEvent -> fetch();
			$query_select_followEvent ->closeCursor();

			$risultato = $result['@res'];

		}catch (PDOException $e) {
			echo"[Errore] followEvent non andato a buon fine ".$e->getMessage();
		}
		
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Sei iscritto all'evento');</script>";
			//echo "Sei iscritto all'evento";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] L'evento è stato chiuso o partecipi già');</script>";
			echo "[ERRORE] L'evento è stato chiuso o partecipi già";
		}
	}

	public function unfollowEvent($nicknameUtente, $titoloEvento){
		

		// echo("CALL UnfollowEvent('$nicknameUtente','$titoloEvento',@res)");
		try{
			$titoloEvento = addslashes($titoloEvento);	
			$query_followEvent = $this -> db -> prepare("CALL UnfollowEvent('$nicknameUtente','$titoloEvento',@res)");
			$query_followEvent -> execute();
			$query_followEvent->closeCursor();

			$query_select_followEvent = $this -> db -> prepare("SELECT @res");
			$query_select_followEvent -> execute();
			$result = $query_select_followEvent -> fetch();
			$query_select_followEvent->closeCursor();

			$risultato = $result['@res'];
		}catch (PDOException $e) {
			echo"[Errore] unfollowEvent non andato a buon fine ".$e->getMessage();
		}
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Non sei più iscritto all'evento');</script>";
			echo "Non sei più iscritto all'evento";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] L'evento è stato chiuso non puoi non seguire più');</script>";
			echo "[ERRORE] L'evento è stato chiuso non puoi non seguire più";
		}
	}

	public function getListaEventi($citta){

		try{
			$citta = addslashes($citta);
			//Titolo,Descrizione,Data,OrarioInizio,CapienzaMAx Evento,AttivitaCommerciale,Indirizzo,Latitudine,Longitudine
			$sql = ("SELECT * from Evento,Attrattiva where Evento.NomeCitta = Attrattiva.NomeCitta and Evento.AttivitaCommerciale = Attrattiva.Nome and Evento.NomeCitta='$citta'");
			
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		return $res;

	}

	public function getEvent($citta,$dataPickeStart, $dataPickeEnd){

		try{
			$citta = addslashes($citta);
			$sql = ("SELECT * from Evento,Attrattiva where Evento.NomeCitta = Attrattiva.NomeCitta and Evento.AttivitaCommerciale = Attrattiva.Nome and Evento.NomeCitta='$citta' and (Evento.Data BETWEEN '$dataPickeStart' AND '$dataPickeEnd')"); 
			$res=$this -> db ->query($sql);

		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}

		return $res;
	}


	public function getInfoEvento($titolo){

		try{
			$titolo = addslashes($titolo);
			$sql = ("SELECT * from Evento,Attrattiva where Evento.NomeCitta = Attrattiva.NomeCitta and Evento.AttivitaCommerciale = Attrattiva.Nome and Evento.Titolo='$titolo'"); 
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		exit();
  		}

		return $res;

	}

	public function getEventsFollowed($nicknameUtente){
		
		try{
			$sql = ("Select TitoloEvento from Follower where NicknameUtente ='$nicknameUtente'"); 
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}

		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['TitoloEvento'];
        	$i++;
  		}
  		return $arr;
	}
	
}


?>