<?php

include_once('user.php');
 if(!isset($_SESSION)) 
    { 
        session_start();
        echo "creo sessione index ";
    } 

if(isset($_POST['submit'])){

	$nickname = $_POST['username'];
	$password = $_POST['password'];

	$object = new User();
	$risultato = $object ->Login($nickname, $password);

	if ($risultato == 1) {

		$object -> getInfoUser($nickname, $password);
		header("Location: http://localhost:/Progetto_0.0.2/home.php"); //per max
		//header("Location: http://localhost:8888/Progetto_0.0.2/home.php"); //per salvo
		die();
				// echo "WELCOME TO SEE MY CITY";
	}else{
		echo "<script type='text/javascript'>alert('Credenziali errate');</script>";
		//echo "Credenziali errate";
		//echo " msgdb : $risultato";
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>
	
<head>

	<!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" href="css/footer.css" type="text/css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
	
	<div id = "Header" align="center">
		<hr><h2 class="ex1"> LOGIN UTENTI </h2></hr>
	</div>

	<div class="center" id = content>
		<form method="post" action="index.php"">
			<table align="center">
				<tr>
					<td> <b class="ex1"> Nickname:   </b></td>
					<td><input type="text" name="username" placeholder="Nickname" required /></td>
				</tr>
				<tr>
					<td> <b class="ex1"> Password:   </b></td>
					<td><input type="password" name="password" placeholder="********" required /></td>
				</tr>
			</table>

			<input type="submit" name="submit" value="Login"/>
		</form>
		<a href= "register.php" class="text-center new-account">Create an account </a>
	</div>

	<?php
		include('footer.php');
	?>

</body>
</html>