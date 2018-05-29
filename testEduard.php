<?php require_once 'header.php'; 

$geslotenVeilingen = handlequery("SELECT * FROM voorwerp v join gebruiker G on v.verkoper = g.gebruikersnaam WHERE looptijdEindeDag <= CONVERT(date, GETDATE()) 
								 AND V.veilingGesloten = 0 AND looptijdEindeTijdstip < CONVERT(time, GETDATE());");

if (isset($_POST['sendmail'])){

		foreach($geslotenVeilingen as $gesloten){
		
		$geslotenParameters = array(':voorwerpnummer' => $gesloten['voorwerpnummer']);
		$subject = 'veiling:' . $gesloten['titel'] . 'is gesloten';
		$message = 'De veiling' .' '. $gesloten['titel'] .' '. 'is Gesloten. De winnar van deze veiling is:' .' '. $gesloten['koper'];
		$email = $gesloten['mailadres'];
		sendMail($email,$subject,$message);
		handlequery("UPDATE voorwerp SET veilingGesloten = 1 WHERE voorwerpnummer = :voorwerpnummer",$geslotenParameters);
			
		}
	}
?>

<main class="geslotenVeilingen">
	<section>
		 <i class="fas fa-plus-circle"></i>
		<form class="form-group" method="POST">
			<input type="submit" class="cta-orange btn" name="sendmail" value="Check veilingen">
		</form>
	</section>
</main>