<?php
session_start();
require_once 'db.php';

$emailaddress = ($_POST['emailaddress']);
$gebruiker = query("SELECT * FROM account WHERE emailaddress=:emailaddress", array(':emailaddress'=>$emailaddress))[0];

if (password_verify($_POST['password'], $gebruiker['password']) ) {
	$_SESSION['email'] = $gebruiker["emailaddress"];
	$_SESSION['firstname'] = $gebruiker["firstname"];
	$_SESSION['lastname'] = $gebruiker["lastname"];
	$_SESSION['accountnumber'] = $gebruiker["accountnumber"];
	$_SESSION['land'] = $gebruiker["country"];
	$_SESSION['geboortedatum'] = $gebruiker["birthdate"];
	$_SESSION['abbonement'] = $gebruiker["contract_type"];
	$_SESSION['login_time'] = time();
	$_SESSION['logged_in'] = true;
	header("location: ./profiel.php");
}
else {
$_SESSION['message_login'] = "Verkeerd wachtwoord of onbekende e-mail, probeer opnieuw!";
}
?>