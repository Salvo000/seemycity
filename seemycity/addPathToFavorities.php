<!-- Button to open the modal login form -->
<!-- <button onclick="document.getElementById('id01').style.display='block'">Commenta</button> -->

<!-- The Modal -->
<div id="id01" class="modal">
	<span onclick="document.getElementById('id01').style.display='none' "  class="close" title="Close Modal">&times;</span>
<!-- Modal Content -->
<form class="modal-content animate" method="POST" action="percorso.php">
  	<div class="container" style="background-color:#f1f1f1" >
		
		<label for="notaDescrittiva"><b>Se ti va, aggiungi una nota descrittiva:</b></label>
		<br>
		<textarea name ="notaDescrittiva"  placeholder="Aggiungi una nota prima di aggiungere questo percorso fra i tuoi preferiti"></textarea>

		<div class="container" style="background-color:#f1f1f1">
   	 		<button type="submit" class="styleOfButtons" name="aggiungiPreferiti" >Aggiungi ai preferiti</button>
   	 		<button type="button"  class="styleOfButtons" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
   	 		
    	</div>
    
    </div>
    </form>
 </div>


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