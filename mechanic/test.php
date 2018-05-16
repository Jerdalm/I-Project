// $randomVerificsendRegistrationCodeationCode = generateRandomCode();
	$randomVerificationCode = 111111;

	$to      = $emailCheck;
	$subject = 'Account activatie';
	$message_body = '
	Beste,

	Bedankt voor het registreren!

	Voer deze code in op de site:
	' . $randomVerificationCode .'.';

	$randomVerificationCode_hashed = md5($randomVerificationCode);	
	
	if (checkEmailUnique($emailCheck)){
		if (filter_var($emailCheck, FILTER_VALIDATE_EMAIL)) {
			setCodeInDB($emailCheck, $randomVerificationCode_hashed);
			sendMail($to, $subject, $message_body, $message);
			header("Location: ./user.php?step=2");		        
			$message_registration0 = 'Er is een email met de verificatiecode naar het opgegeven emailadres gestuurd.';
		} else {
			header("Location: ./user.php");
			$message_registration = 'Geen geldig e-mailadres.';
		}
	} else {
		header("Location: ./user.php");
		$message_registration = 'Er bestaat al een account met dit e-mailadres.';
	}
	return $message_registration;