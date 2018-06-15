<?php


include_once('connection.php');

 if(!isset($_SESSION)) 
    { 
        session_start();
        // echo "creo sessione utente ";
    }


/**
* 
*/
class Statistica
{
	private $db;

	public function __construct(){
		$this -> db = new Connection();
		$this -> db = $this -> db -> dbConnect();

	}


	public function ListaAttrattiveVotate(){
		try{
			$sql = "SELECT NomeAttrattiva, NomeCitta, SUM(Votazione) AS Votazione, COUNT(*) AS Totale FROM Commento GROUP BY NomeAttrattiva, NomeCitta ORDER BY Totale DESC";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['NomeAttrattiva'];
        	$arr[$i][] = $row['NomeCitta'];
        	$arr[$i][] = $row['Votazione'];
        	$arr[$i][] = $row['Totale'];
        	$i++;
  		}
  		

  		$lista = array();
  		for ($j=0; $j < count($arr); $j++) {
  			$lista[$j][0] =  $arr[$j][0];
  			$lista[$j][1] =  $arr[$j][1];
  			$lista[$j][2] =  $arr[$j][2]/$arr[$j][3];
  			$lista[$j][3] =  $arr[$j][3];
  		}

    //ordinamento della lista
    for ($t=1; $t < count($lista); $t++) { 
        for ($j=0; $j < count($lista) - 1; $j++) { 
          $k = $j+1;
          $a0 = $lista[$j][0];
          $a1 = $lista[$j][1];
          $a2 = $lista[$j][2];
          $a3 = $lista[$j][3];
          $b0 = $lista[$k][0];
          $b1 = $lista[$k][1];
          $b2 = $lista[$k][2];
          $b3 = $lista[$k][3];
          if ($b2 > $a2) {
            $lista[$j][0] = $b0;
            $lista[$j][1] = $b1;
            $lista[$j][2] = $b2;
            $lista[$j][3] = $b3;
            $lista[$k][0] = $a0;
            $lista[$k][1] = $a1;
            $lista[$k][2] = $a2;
            $lista[$k][3] = $a3;
          }
        }
      }

		return $lista;
	}

	public function ListaPercorsiPreferiti(){
		try{
			$sql = "SELECT pr.CodicePercorso AS Codice, pe.NomeCitta AS Citta, COUNT(*) AS Totale FROM Preferiti AS pr JOIN Percorso AS pe ON pr.CodicePercorso = pe.Codice GROUP BY CodicePercorso ORDER BY Totale DESC";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}

  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['Codice'];
        	$arr[$i][] = $row['Citta'];
        	$arr[$i][] = $row['Totale'];
        	$i++;
  		}

  		return $arr;
	}

	public function ListaUtentiPiuAttivi(){
		try{
			$sql = "SELECT NicknameUtente, COUNT(*) AS Totale FROM Attrattiva GROUP BY NicknameUtente ORDER BY Totale DESC";
			$res=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}

  		$arr = array();
  		$i = 0;
  		foreach ($res as $row) {
        	$arr[$i][] = $row['NicknameUtente'];
        	$arr[$i][] = $row['Totale'];
        	$arr[$i][] = 0;
        	$arr[$i][] = 0;
        	$i++;
  		}

  		try{
			$sql = "SELECT NicknameUtente, COUNT(*) AS Totale FROM Percorso GROUP BY NicknameUtente";
			$res2=$this -> db ->query($sql);
		}catch(PDOException $e) {
    		echo("[ERRORE] Query SQL non riuscita. Errore: ".$e->getMessage());
    		// exit();
  		}
  		
  		$arr2 = array();
  		$j = 0;
  		foreach ($res2 as $row) {
        	$arr2[$j][] = $row['NicknameUtente'];
        	$arr2[$j][] = $row['Totale'];
        	$j++;
  		}

  		for ($k=0; $k < count($arr); $k++) { 
  			$trovato = 0;
  			for ($y=0; $y < count($arr2); $y++) { 
  				if ($arr[$k][0] == $arr2[$y][0]) {
  					$arr[$k][2] = $arr2[$y][1];
  					$arr[$k][3] = $arr[$k][1] + $arr2[$y][1];
  					$trovato = 1;
  				}
  			}
  			if ($trovato == 0) {
  				$arr[$k][3] = $arr[$k][1];
  			}
  		}

      //ordinamento della lista
    for ($t=1; $t < count($arr); $t++) { 
        for ($j=0; $j < count($arr) - 1; $j++) { 
          $k = $j+1;
          $a0 = $arr[$j][0];
          $a1 = $arr[$j][1];
          $a2 = $arr[$j][2];
          $a3 = $arr[$j][3];
          $b0 = $arr[$k][0];
          $b1 = $arr[$k][1];
          $b2 = $arr[$k][2];
          $b3 = $arr[$k][3];
          if ($b3 > $a3) {
            $arr[$j][0] = $b0;
            $arr[$j][1] = $b1;
            $arr[$j][2] = $b2;
            $arr[$j][3] = $b3;
            $arr[$k][0] = $a0;
            $arr[$k][1] = $a1;
            $arr[$k][2] = $a2;
            $arr[$k][3] = $a3;
          }
        }
      }

  		return $arr;

	}

}

?>