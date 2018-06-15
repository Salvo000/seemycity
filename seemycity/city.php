<?php


include_once('connection.php');

if(!isset($_SESSION)){ 
    session_start(); 
}

/**
* 
*/
class City
{
	
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}

	public function insertCitta($nome, $regione, $stato){
		
		try{
		$nome = addslashes($nome);
		$regione = addslashes($regione);
		$stato = addslashes($stato);
		$query_insertCitta = $this -> db -> prepare("CALL InsertCitta('$nome','$regione','$stato',@res)");
		$query_insertCitta -> execute();
		$query_insertCitta->closeCursor();

		$query_select_insertCitta = $this -> db -> prepare("SELECT @res");
		$query_select_insertCitta -> execute();
		$result = $query_select_insertCitta -> fetch();
		$query_select_insertCitta->closeCursor();+

		$risultato = $result['@res'];

		}catch (PDOException $e) {
			return"[Errore] InsertCitta non andato a buon fine ".$e->getMessage();
		}
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Città inserita con successo');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Impossibile aggiungere la città');</script>";
		}
	}

	public function insertFoto($codice, $titolo, $nomeCitta, $PathFoto){
		

		try{
			$titolo = addslashes($titolo);
			$nomeCitta = addslashes($nomeCitta);
			$query = $this -> db -> prepare("CALL InsertFoto('$codice','$titolo','$nomeCitta','$PathFoto',@res)");
			$query -> execute();
			$query->closeCursor();

			$query_select = $this -> db -> prepare("SELECT @res");
			$query_select -> execute();
			$result = $query_select -> fetch();
			$query_select->closeCursor();
			
			$risultato = $result['@res'];

		}catch (PDOException $e) {
			return"[Errore] insertFoto non andato a buon fine ".$e->getMessage();
		}
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Foto inserita con successo');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Impossibile aggiungere la foto');</script>";
		}	
	}

	public function displayListaCitta(){
		try{
			$sql = "SELECT * FROM Citta";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['Nome'];
        	$arr[$i][] = $row['Regione'];
        	$arr[$i][] = $row['Stato'];
        	$i++;
  		}
  		return $arr;

	}

	public function displayListaFotoCitta($citta){
		try{
			$citta = addslashes($citta);
			$sql = "SELECT * FROM Foto WHERE NomeCitta = '$citta'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
  			$arr[$i][] = $row['PathFoto'];
        	$arr[$i][] = $row['Titolo'];
        	$i++;
  		}
  		return $arr;

	}
}



?>