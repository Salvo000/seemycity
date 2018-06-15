<?php
 
	if(!isset($_SESSION)){
 		session_start();
	}
?>
<!-- Button to open the modal login form -->
<!-- <button onclick="document.getElementById('id01').style.display='block'">Commenta</button> -->

<!-- The Modal -->
<div id="id03" class="modal">
	<span onclick="document.getElementById('id03').style.display='none' "  class="close" title="Close Modal">&times;</span>
<!-- Modal Content -->
	<img src=<?php echo " ".$_SESSION["fotoAttrattiva"]." "; ?>  width="600" height="400">
</div>
<script>
// Get the modal
var modal = document.getElementById('id03');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>