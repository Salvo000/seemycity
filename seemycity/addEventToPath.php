
<?php
	/*Si apre un form dove:

	1.c'è la lista di tutti i percorsi per quell'utente
	2.l'utente può selezionare il percorso su cui aggiungere un evento, trascorsa la data dell'evento rimane il percorso 
	3.l'utente compila il form e aggiunge quello che serve poi si aggiunge l'evento al percorso

	*/

?>
<!-- Button to open the modal login form -->
<!-- <button onclick="document.getElementById('id01').style.display='block'">Commenta</button> -->

<!-- The Modal -->
<div id="id01" class="modal">
	<span onclick="document.getElementById('id01').style.display='none' "  class="close" title="Close Modal">&times;</span>
<!-- Modal Content -->
<form class="modal-content animate" method="POST" action="attrattiva.php">
  	<div class="container" style="background-color:#f1f1f1" >
		
		<label for="recensione"><b>Recensione:</b></label>
		<input type="text" placeholder="Inserisci la tua recensione" name="recensione" required>
		<br>
		
		<label for="votazione"><b> Votazione: </b></label>
		<select name="votazione" required>
			<option value = "1" >1</option>
			<option value = "2" >2</option>
			<option value = "3" >3</option>
			<option value = "4" >4</option>
			<option value = "5" >5</option>
		</select>
		<br>
		<label for="giornovisita"><b> Giorno della Visita: </b></label>
		<input type="date" name="giornovisita" required>
		<br>
		<label for="ora"><b> Ora della visita: </b></label>
		<input type="time" name="ora" required>
		<br>

		<div class="container" style="background-color:#f1f1f1">
   	 		<button type="submit" id="newComment" name="newComment" >Aggiungi Commento</button>
   	 		<button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
   	 		
    	</div>
    
    </div>
 </div>

</form>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>