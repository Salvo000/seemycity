<?php
//https://www.mrwebmaster.it/javascript/semplice-chat-ajax-php_7425_4.html
  if(!isset($_SESSION)){
    session_start();
    echo "session_start in chat.php";
  }
  include_once("user.php");
  
  include_once('connection.php');
  
  $pdo = new Connection();
  $pdo = $pdo -> dbConnect();

  if(isset($_POST["send"]) ){
     
    $descrizione = $_POST["desc"];
    $titolo = $_POST["titolo"];
    $mittente = $_SESSION["uname"];
    $tipo = "privato";
    if(!isset($object))
      { 
        $object = new User();
      }
    $response = $object ->sendMessage($_POST["titolo"], $descrizione, $mittente , $user_receiver, $tipo);

    echo "<p><br><br>".$response."</p>";
  }

  /*
    ho bisogno di una classe che mi gestisca 
  "chat.php": sarà la parte più importante del front-end, consentirà infatti di inserire messaggi e leggerli.conterrà il codice preposto all'inserimento dei messaggi generando i diversi records.

  "chat.js": il file che conterrà il codice Javascript per l'aggirnamento dell'interfaccia di discussione.. 

  "ajax.php": avrà il compito di estrarre, contare e mostrare i messaggi scritti dagli utenti.
  */

?>


<!DOCTYPE html>
<html>
<head>
  <title>SeeMyCity</title>
  

<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <!--<link rel="stylesheet" type="text/css" href="menu.css">-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <meta charset="utf-8" name = "viewport" content="width: device-width, initial - scale: 1.0">
  <script src="script1.js"></script>
  <link rel="stylesheet" href="css/chat.css" type="text/css" />
  <link rel="stylesheet" href="css/forum.css" type="text/css"/>
  <link rel="stylesheet" href="css/footer.css" type="text/css" />
</head>
<body>
<?php
  include("menu.php");
?>
  
  <div class = "nav" id="cronologia" >
    <table>

<?php
  
      if(!isset($object))
      { 
        $object = new User();
      }
      $res = $object -> getListaMessaggiPubblici();
      // $object -> sendAckVisualized($user_receiver);
      $x=1;
      for($x = 1; $row =  $res -> fetch(); x++){
      
        if((x%2)==0){
          echo('<tr><td><p text-align = "right" > "< inviato" <br><b>'.$row["Titolo"]." </b> <br>'".$row["Descrizione"]."'</p> </td> </tr> " );
          echo('<div class="container"><img src="/w3images/bandmember.jpg" alt="Avatar"><p>Hello. How are you today?</p><span class="time-right">11:00</span></div>');
        }
        else
        {
        // echo" sono destinatario";
        echo('<tr><td><p text-align = "left"> "received >" <br><b> '.$row["Titolo"]."</b> <br>' ".$row["Descrizione"]."'</p> </td> </tr> " );
        }
    }
?>
      </table>
    </div>
  <div class = "message">
      <table>
        <tr>
          <td id = "col"><i class="material-icons" style="font-size:60px;color:red;text-shadow:2px 2px 4px #000000;">favorite</i><i class="material-icons" style="font-size:60px;color:lightblue;text-shadow:2px 2px 4px #000000;" >attachment</i></td>
          <!-- <td id = "col" ></td> -->
          <td id = "col2" >
            <form  action = "chat.php" method="post">
              <input id="col3" type="text" size="50" maxlength="200" name="titolo" placeholder="Inserisci un titolo" >
              <input id="col3" type="text" size="50"  name="desc" placeholder="Corpo del messaggio" >
              <input type="submit" value="send" name="send" >
                <p>Clicca su send per inviare un messaggio</p>
            </form>
          </td>

        </tr>
      </table>
  </div>
  
  <?php
  include("footer.php");
  ?>

</body>
</html>




<!-- <div class="container">
  <img src="/w3images/bandmember.jpg" alt="Avatar">
  <p>Hello. How are you today?</p>
  <span class="time-right">11:00</span>
</div>

<div class="container darker">
  <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right">
  <p>Hey! I'm fine. Thanks for asking!</p>
  <span class="time-left">11:01</span>
</div>

<div class="container">
  <img src="/w3images/bandmember.jpg" alt="Avatar">
  <p>Sweet! So, what do you wanna do today?</p>
  <span class="time-right">11:02</span>
</div>

<div class="container darker">
  <img src="/w3images/avatar_g2.jpg" alt="Avatar" class="right">
  <p>Nah, I dunno. Play soccer.. or learn more coding perhaps?</p>
  <span class="time-left">11:05</span>
</div> -->