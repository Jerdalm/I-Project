<?php require_once 'header.php'; 
$gebruikersnaam = $_GET['gebruikersnaam'];
$emailParameters = array(':gebruikersnaam' => $gebruikersnaam);
$vraag = handlequery("SELECT vraag FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam", $emailParameters);

$vraagUser = $vraag[0]['vraag'];
?>
<main>

<form>
<div class="form-group">
	<label for="testvoorvraag">  <?php echo $vraagUser ?> </label>
	<input type="text" class="form-control" id="testAntwoordvakje" placeholder="Antwoord">
</form>

</main>


<?php require_once 'footer.php'; ?>