<?php require_once 'header.php'; 

$geslotenVeilingen = handlequery("SELECT * FROM voorwerp v join gebruiker G on v.verkoper = g.gebruikersnaam WHERE looptijdEindeDag >= CONVERT(date, GETDATE()) 
								  AND looptijdEindeTijdstip > CONVERT(time, GETDATE());");

$email = $geslotenVeilingen[0]['mailadres'];
$subject = 'veiling:' . $geslotenVeilingen[0]['titel'] . 'is gesloten';
$message = 'De veiling' . $geslotenVeilingen[0]['titel'] . 'is Gesloten. De winnar van deze veiling is' . $geslotenVeilingen[0]['koper'];

if (isset($_POST['sendmail']) && $geslotenVeilingen[0]['veilingGesloten'] ){
	
		$geslotenParameters = array(":veilingGesloten" => $geslotenVeilingen[0]['voorwerpnummer']);
		sendMail($email,$subject,$message);
		handlequery("UPDATE voorwerp SET veilingGesloten = 1 WHERE voorwerp = :voorwerpnummer");
}
?>
<main class="">
	<section>
		<form class="form-group" method="POST">
			<input type="button" class="cta-orange btn" name="sendmail" value="sendMail">
		</form>
	</section>
</main>