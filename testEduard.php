<?php require_once 'header.php'; 


// hier worden de mailtjes gestuurd voor de veilingen die nog op 0 staan en afgelopen zijn
if (isset($_POST['sendmail'])){
		sendEmailClosedAuctions();

		
	}

function getUserData($user){
	$return = handlequery("SELECT * FROM voorwerp v join gebruiker G on v.".$user." = g.gebruikersnaam WHERE looptijdEindeDag <= CONVERT(date, GETDATE()) 
								 		  AND V.veilingGesloten = 0 AND looptijdEindeTijdstip < CONVERT(time, GETDATE());");
	return $return;
}


function sendEmailClosedAuctions(){
	foreach(getUserData("verkoper") as $gesloten){
		$email = $gesloten['mailadres'];
		$subject = 'veiling:' . $gesloten['titel'] . 'is gesloten';
		if(!empty ($gesloten['koper'])) {
			$message = 'De veiling' .' '. $gesloten['titel'] .' '. 'is Gesloten. de veiling is gewonnen door:' . $gesloten['koper'] . '.Bekijk de veiling op: http://localhost/EenmaalAndermaal/GitHub/I-Project/productpage.php?product=' . $gesloten['voorwerpnummer'];
		} else {
			$message = 'De veiling' .' '. $gesloten['titel'] .' '. 'is Gesloten. Uw veiling heeft jammer genoeg geen koper. Bekijk de veiling op: http://localhost/EenmaalAndermaal/GitHub/I-Project/productpage.php?product=' . $gesloten['voorwerpnummer'];
		}
		sendMail($email,$subject,$message);
	}
			
	foreach(getUserData("koper") as $gesloten){
		if (!empty($gesloten['koper'])){
			$subject = 'Gefeliciteerd u heeft veiling:' . $gesloten['titel'] . ' ' . 'Gewonnen!';
			$message = 'De veiling' .' '. $gesloten['titel'] .' '. 'is Gesloten. Gefeliciteerd! U bent de winnaar van deze Veiling. Bekijk de veiling op: http://localhost/EenmaalAndermaal/GitHub/I-Project/productpage.php?product=' . $gesloten['voorwerpnummer'];
			$email = $gesloten['mailadres'];
			sendMail($email,$subject,$message);
		}
	}
}
?>



<main class="geslotenVeilingen">
	<section>

		<form class="form-group" method="POST">
			<input type="submit" class="cta-orange btn" name="sendmail" value="Check veilingen">
		</form>
	</section>
</main>