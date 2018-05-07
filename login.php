<?php
require_once './head.php';
require_once './db.php';

$emailadres = ($_SESSION['email-login']);
$wachtwoord = ($_SESSION['wachtwoord']);

$emailParam = array(':mailadres'=>$emailadres);
$gebruiker = handleQuery("SELECT * FROM Gebruiker WHERE mailadres=:mailadres", $emailParam)[0];

$wachtwoord = trim($wachtwoord);
$gebruiker['wachtwoord'] = trim($gebruiker['wachtwoord']);

if (password_verify($wachtwoord, $gebruiker['wachtwoord']) || $wachtwoord == $gebruiker['wachtwoord']) {
	echo '<script type="text/javascript">alert("Werkt het beste");</script>';
    
	$_SESSION['email'] = $gebruiker["mailadres"];
	$_SESSION['gebruikersnaam'] = $gebruiker["gebruikersnaam"];
	$_SESSION['voornaam'] = $gebruiker["voornaam"];
	$_SESSION['achternaam'] = $gebruiker["achternaam"];
	$_SESSION['adresregel1'] = $gebruiker["adresregel1"];
	$_SESSION['adresregel2'] = $gebruiker["adresregel2"];
	$_SESSION['postcode'] = $gebruiker["postcode"];
	$_SESSION['plaatsnaam'] = $gebruiker["plaatsnaam"];
	$_SESSION['land'] = $gebruiker["land"];
	$_SESSION['geboortedag'] = $gebruiker["geboortedag"];
	$_SESSION['wachtwoord'] = $gebruiker["wachtwoord"];
	$_SESSION['vraag'] = $gebruiker["vraag"];
	$_SESSION['antwoordtekst'] = $gebruiker["antwoordtekst"];
	$_SESSION['soortGebruiker'] = $gebruiker["soortGebruiker"];
	$_SESSION['logged-in'] = true;
	header("location: ./user-details.php");
}
else {
	$_SESSION['message_login'] = "Verkeerd wachtwoord of onbekende e-mail, probeer opnieuw!";
}
?>