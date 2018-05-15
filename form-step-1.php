<?php
require_once './head.php';
require_once './db.php';

//$randomVerificationCode = generateRandomCode();
$randomVerificationCode = 111111;
$subject = 'Activatiecode';
$body = 'Bedankt voor het registreren,
Voer de volgende activatiecode in het formulier in:' . $randomVerificationCode;
$headerLocationIf = "registreren.php?step=2";
$headerLocationElse = "registreren.php";

if (isset($_POST['submit-mail'])){
	if (checkIfFieldsFilledIn()) {
		if (checkEmailUnique($_POST['email'])) {
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				$_SESSION['email-registration'] = $_POST['email'];
				sendCode($_POST['email'], $subject, $body, $headerLocationIf, $headerLocationElse, $randomVerificationCode);
			} else {
				$message_registration = 'Dit is geen geldig e-mailadres';
			}
		} else {
			$message_registration = 'Er bestaat al een account met dit e-mailadres.';
		}
	} else {
		$message_registration = 'U heeft het veld nog niet ingevuld.';

	}
}
?>

<form method="post" class="form-steps">
	<div class="form-group">
		<label for="inputEmail">E-mail</label>
		<input type="textarea" class="form-control" name="email" id="inputEmail">
	</div>

	<button type="submit" name="submit-mail" value="send-code" class="btn btn-primary btn-sm">Code sturen</button>
</form>
