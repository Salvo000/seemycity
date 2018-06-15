<?php


include_once('connection.php');

if(!isset($_SESSION)){ 
    session_start(); 
}

/**
* 
*/
class Path
{
	
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}

	public function insertFavoritePath($nicknameUtente, $codicePercorso,$nota){
		
		try{
			$nota = addslashes($nota);
			$codicePercorso = addslashes($codicePercorso);
			$query_favoritePath = $this -> db -> prepare("CALL InsertFavoritePath('$nicknameUtente','$codicePercorso','$nota',@res)");
			$query_favoritePath -> execute();
			$query_favoritePath ->closeCursor();

			$query_select_favoritePath = $this -> db -> prepare("SELECT @res");
			$query_select_favoritePath -> execute();
			$result = $query_select_favoritePath -> fetch();
			$query_select_favoritePath->closeCursor();

			$risultato = $result['@res'];

		}catch (PDOException $e) {
			echo"[Errore] insertFavoritePath non andato a buon fine ".$e->getMessage();
		}
		
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Aggiunto ai preferiti');</script>";
			//echo "Aggiunto ai preferiti";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Il percorso non può essere aggiunto');</script>";
			//echo "[ERRORE] Il percorso non può essere aggiunto";
		}
	}

	public function deleteFavoritePath($nicknameUtente, $codicePercorso){
		// echo("CALL DeleteFavoritePath('$nicknameUtente','$codicePercorso',@res)");
		try{
		$codicePercorso = addslashes($codicePercorso);
		$query_favoritePath = $this -> db -> prepare("CALL DeleteFavoritePath('$nicknameUtente','$codicePercorso',@res)");
		$query_favoritePath -> execute();
		$query_favoritePath->closeCursor();

		$query_select_favoritePath = $this -> db -> prepare("SELECT @res");
		$query_select_favoritePath -> execute();
		$result = $query_select_favoritePath -> fetch();
		$query_select_favoritePath->closeCursor();

		$risultato = $result['@res'];

		}catch (PDOException $e) {
			echo"[Errore] deleteFavoritePath non andato a buon fine ".$e->getMessage();
			// return $e->getMessage();
		}

		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Percorso cancellato dai preferiti');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Il percorso non può essere cancellato dai preferiti');</script>";
		}
	}

	public function insertPath($codice, $durata, $nome, $categoria, $nomeCitta, $nicknameUtente){
		try{
			$codice = addslashes($codice);
			$nome = addslashes($nome);
			$nomeCitta = addslashes($nomeCitta);
			$query_insertPath = $this -> db -> prepare("CALL InsertPath('$codice','$durata','$nome','$categoria','$nomeCitta','$nicknameUtente',@res)");
			$query_insertPath -> execute();
			$query_insertPath ->closeCursor();
			
			$query_select_insertPath = $this -> db -> prepare("SELECT @res");
			$query_select_insertPath -> execute();
			$result = $query_select_insertPath -> fetch();
			$query_select_insertPath ->closeCursor();

			$risultato = $result['@res'];
		}catch (PDOException $e) {
			echo"[Errore] insertPath non andato a buon fine ".$e->getMessage();
			echo"CALL InsertPath('$codice','$durata','$nome','$categoria','$nomeCitta','$nicknameUtente',@res)";
			// return $e->getMessage();
		}
		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Percorso inserito con successo');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Impossibile inserire il percorso');</script>";
		}
	}

	public function insertAttrattivaInPath($nomeAttrattiva, $nomeCitta, $codicePercorso, $tempoVisita, $nicknameUtente){
		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$nomeCitta = addslashes($nomeCitta);
			$codicePercorso = addslashes($codicePercorso);
			$query_insertAttrattiva = $this -> db -> prepare("CALL InsertAttrattivaInPath('$nomeAttrattiva','$nomeCitta','$codicePercorso','$tempoVisita','$nicknameUtente',@res)");
			$query_insertAttrattiva -> execute();
			$query_insertAttrattiva->closeCursor();

			$query_select_insertAttrattiva = $this -> db -> prepare("SELECT @res");
			$query_select_insertAttrattiva -> execute();
			$result = $query_select_insertAttrattiva -> fetch();
			$query_select_insertAttrattiva->closeCursor();

			$risultato = $result['@res'];
		}catch (PDOException $e) {
			echo"[Errore] insertAttrattivaInPath non andato a buon fine ".$e->getMessage();
		}

		if ($risultato == 1) {
			echo "<script type='text/javascript'>alert('Attrattiva inserita al percorso');</script>";
		}else{
			echo "<script type='text/javascript'>alert('[ERRORE] Impossibile inserire l'attrattiva');</script>";
		}
	}


	public function displayListaPercorsi(){
		try{
			$sql = "SELECT * FROM Percorso";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['Codice'];
        	$arr[$i][] = $row['Durata'];
        	$arr[$i][] = $row['Nome'];
        	$arr[$i][] = $row['Categoria'];
        	$arr[$i][] = $row['NomeCitta'];
        	$arr[$i][] = $row['NicknameUtente'];
        	$i++;
  		}
  		return $arr;

	}

	public function displayListaAttrattiveInPercorso($codicePercorso){
		
		try{
			$codicePercorso = addslashes($codicePercorso);
			$sql = "SELECT * FROM Inclusione WHERE CodicePercorso = '$codicePercorso'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
  			$arr[$i][] = $row['Ordine'];
        	$arr[$i][] = $row['NomeAttrattiva'];
        	$arr[$i][] = $row['NomeCitta'];
        	$arr[$i][] = $row['TempoVisita'];
        	$i++;
  		}
  		return $arr;

	}

	public function displayCoordinateAttrattiva($nomeAttrattiva, $nomeCitta){
		try{
			$nomeAttrattiva = addslashes($nomeAttrattiva);
			$nomeCitta = addslashes($nomeCitta);
			$sql = "SELECT * FROM Attrattiva WHERE Nome = '$nomeAttrattiva' AND NomeCitta = '$nomeCitta'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
  			$arr[$i][] = $row['Nome'];
        	$arr[$i][] = $row['Longitudine'];
        	$arr[$i][] = $row['Latitudine'];
        	$i++;
  		}
  		return $arr;
	}

	public function displayListaPreferiti($nickname){
		try{
			$sql = "SELECT * FROM Preferiti WHERE NicknameUtente = '$nickname'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		return("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['NicknameUtente'];
        	$arr[$i][] = $row['CodicePercorso'];
        	$arr[$i][] = $row['NotaDescrittiva'];
        	$i++;
  		}
  		return $arr;

	}

	public function viewPercorso($codice){
		try{
			$codice = addslashes($codice);
			$sql = "SELECT * FROM Percorso WHERE Codice ='$codice'";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$risposta = 0;
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
		    $arr['Codice'] = $row['Codice'];
		    $arr['Durata'] = $row['Durata'];
		    $arr['Nome'] = $row['Nome'];
		    $arr['Categoria'] = $row['Categoria'];
		    $arr['NomeCitta'] = $row['NomeCitta'];
		    $arr['nicknameUtente'] = $row['NicknameUtente'];
			$i++;
		}
	    if (count($arr) > 0){
	  		$risposta = 1;
  		}else{
  			$risposta = 2;
  		}

  		if ($risposta == 1) { //?questa non l'ho capita
			// echo "Welcome to See My City !";
			$_SESSION['codicePercorso'] = $arr['Codice'];
			header("Location: http://localhost:/Progetto_0.0.2/percorso.php"); //per max
			//header("Location: http://localhost:8888/Progetto_0.0.2/home.php"); //per salvo
			die();
			// echo "WELCOME TO SEE MY CITY";
		}else{
			echo "<script type='text/javascript'>alert('Percorso inesistente');</script>";
		}

  		return $risposta;
	}

}




?>