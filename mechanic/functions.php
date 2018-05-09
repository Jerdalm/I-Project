<?php

/* Deze functie zorgt voor de connectie met de Database */	
function ConnectToDatabase(){
	$hostname = "(local)";
	$dbname = "EENMAALANDERMAAL";
	$dbusername = "sa";
	$dbpw = "12345";

	try {$pdo = new PDO("sqlsrv:Server=$hostname;Database=$dbname;
		ConnectionPooling=0", "$dbusername", "$dbpw");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
	die();
}
}

/* Deze functie geeft een array terug met de SELECT RESULTATEN */
function FetchSelectData($sql, $parameters = false){

	global $pdo;
	$qry = $pdo->prepare("$sql");	

	if($parameters){

		$qry->execute($parameters);
	}else{$qry->execute();}

	$result = $qry->fetchALL();
	return $result;
}

/* Deze fucntie voert een sql query uit en geeft een resultaatmelding terug */
function executequery($sql, $parameters = false){

	global $pdo;

	$qry = $pdo->prepare("$sql");	

	if($parameters){

		$data =	$qry->execute($parameters);
	}
	else{
		$data =$qry->execute();
	}

	if($data){
		return 'Opdracht volbracht!';
	}else {
		return 'Opdracht kon niet worden volbracht.';
	}
}

/* Deze functie handeld elke database query af 
	|Voor elke functie kan voor elke functie gebruikt|
*/
function handlequery($sql, $parameters = false){
	global $pdo;
	$first_word = strtok($sql, " ");
	$type = preg_replace('/\s+/', '', $first_word);

	if($type == 'SELECT'){ $data = FetchSelectData($sql,$parameters);}
	else{$data = executequery($sql,$parameters);}

	return $data;
}

function sendMail($to, $subject, $body, $message = "Fout"){
	$emailTo      = $to;
	$subjectEmail = $subject;
	$message_body = $body;


    //mail( $emailTo, $subjectEmail, $message_body ); moet uiteindelijk wel aan!
    echo '<script> alert("'.$body.'")</script>'; //geeft binnen een alert-box de body aan, wat eigenlijk binnen de mail staat

    $_SESSION['message'] = $message;
}

function createRandomPassword() { 

	$chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
	srand((double)microtime()*1000000); 
	$i = 0; 
	$pass = '' ; 

	while ($i <= 7) { 
		$num = rand() % 33; 
		$tmp = substr($chars, $num, 1); 
		$pass = $pass . $tmp; 
		$i++; 
	} 

	return $pass; 

}

function checkIfFieldsFilledIn(){ // returnt true als de meegegeven velden gevuld zijn 
	if (count(array_filter($_POST)) == count($_POST)) {
		return true;
	} else {			
		return false;
	}
}

function checkEmailUnique($emailCheck){
	$emailControl = handleQuery("SELECT * FROM Gebruiker WHERE mailadres = :mailadres",array(':mailadres' => $emailCheck));
	
	if(count($emailControl) == 0) {
		$state = true;
	} else {
		$state = false;
	}
	return $state;
}

function is_Char_Only($Invoer){
	return (bool)(preg_match("/^[a-zA-Z ]*$/", $Invoer)) ;
}
		
function showLoginMenu(){
	$htmlLogin = ' ';
	if(isset($_SESSION['gebruikersnaam']) && !empty($_SESSION['gebruikersnaam'])){ 
        $htmlLogin = '<li class="nav-item">';
        $htmlLogin .= '<a class="nav-link" href="./logout.php">Uitloggen</a>';
        $htmlLogin .= '</li>';
    } else {
	    $htmlLogin = '<li class="nav-item">';
        $htmlLogin .= '<a class="nav-link" href="./user.php">Inloggen|Registreren</a>';
        $htmlLogin .= '</li>';
    }
    return $htmlLogin;
}

function is_email($Invoer){
	return (bool)(preg_match("/^([a-z0-9+-]+)(.[a-z0-9+-]+)*@([a-z0-9-]+.)+[a-z]{2,6}$/ix",$Invoer));
}

function generateRandomCode(){
	return uniqueid(rand(100000,900000),true);
}

function sendRegistrationCode($emailCheck){
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
}  

function checkUsernamePassword($username, $password, $passwordrepeat){
	if ($password != $passwordrepeat) {
		$message_registration = "de wachtwoorden komen niet overeen";
		header("Location: ./user.php?step=3");
	} else {		   
		$getUserParameters = array(':gebruikersnaam' => $username);
		$getUserQuery =  handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam", $getUserParameters);

		if(count($getUserQuery) > 0) {
			$message_registration = "uw ingevoerde gebruikersnaam bestaat al";
			header("Location: ./user.php?step=3");
		} else {

			$password_hashed = password_hash($password , PASSWORD_DEFAULT);

			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password_hashed;

			$_SESSION["message_registration"] = '';
			header("Location: ./user.php?step=4");
		}
	}
}

function insertRegistrationinfoInDB(){
	$voornaam = $_POST['firstname'];
	$achternaam = $_POST['lastname'];
	$adresregel1 = $_POST['adres1'];
	$adresregel2 = $_POST['adres2'];
	$postcode = $_POST['postalcode'];
	$plaatsnaam = $_POST['residence'];
	$land = $_POST['country'];
	$telefoonnummer = $_POST['phonenumber'];
	$birthdate = $_POST['birthdate'];
	$geboortedag = $_POST['birthdate']; 
	$myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
	$geboortedag = $myDateTime->format('Y-m-d');
	$vraag = $_POST['secretquestion'];
	$antwoordtekst = $_POST['secretanswer'];
	
	if(is_numeric($telefoonnummer)){
		$insertInfoParam = array(':voornaam' => $voornaam, ':achternaam' => $achternaam, ':adresregel1' => $adresregel1, ':adresregel2' => $adresregel2, ':postcode' => $postcode, ':plaatsnaam' => $plaatsnaam, ':land' => $land, ':geboortedag' => $geboortedag,':vraag' => $vraag, ':antwoordtekst' => $antwoordtekst);
		$insertInfoQuery = handlequery("INSERT INTO Gebruiker VALUES('".$_SESSION['username']."', :voornaam, :achternaam, :adresregel1, :adresregel2, :postcode, :plaatsnaam, :land, :geboortedag, '".$_SESSION['email-registration']."', '".$_SESSION['password']."', :vraag, :antwoordtekst, 1)", $insertInfoParam);

		$insertTelParam = array(':gebruikersnaam' => $_SESSION['username'], ':telefoonnummer' => $telefoonnummer);

		$insertTelQuery = handlequery("INSERT INTO gebruikerstelefoon VALUES(:gebruikersnaam, :telefoonnummer)", $insertTelParam);

		session_destroy();
		header('Refresh:0; url=./user.php');
		$message_registration = ' ';
	} else {
		$message_registration = 'Het opgegeven telefoonnummer klopt niet.';
	}
	return $message_registration;
}

function setCodeInDB($email, $hashed_code){
	$parameters = array(':mailadres' => "$email");
	$emailUnique = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres", $parameters);

	if (count($emailUnique) > 0){ //kijkt of de email al bestaat in het tabel activatiecode, indien ja: update het mialadres met een 
		$parameters = array(':mailadres' => "$email", ':verifycode' => "$hashed_code"); //nieuwe code & de nieuwe tijd
		handleQuery("UPDATE ActivatieCode 
			SET code = :verifycode, tijdAangevraagd = GETDATE() 
			WHERE mailadres = :mailadres", $parameters);
	} else {
		$parameters = array(':mailadres' => "$email", ':verifycode' => "$hashed_code");
		handleQuery("INSERT INTO ActivatieCode VALUES (0 ,:verifycode ,:mailadres, GETDATE())",$parameters);
	}
}

function loginControl($email, $wachtwoord){

	$emailParam = array(':mailadres'=>$email);
	$gebruiker = handleQuery("SELECT * FROM Gebruiker WHERE mailadres=:mailadres", $emailParam)[0];

	$wachtwoord = trim($wachtwoord);
	$gebruiker['wachtwoord'] = trim($gebruiker['wachtwoord']);

	if (password_verify($wachtwoord, $gebruiker['wachtwoord']) || $wachtwoord == $gebruiker['wachtwoord']) {

		$_SESSION['email'] = $gebruiker["mailadres"];
		$_SESSION['gebruikersnaam'] = $gebruiker["gebruikersnaam"];
		$_SESSION['voornaam'] = $gebruiker["voornaam"];
		$_SESSION['achternaam'] = $gebruiker["achternaam"];
		$_SESSION['adresregel1'] = $gebruiker["adresregel1"];
		if(!empty($gebruiker['adresregel2'])){
			$_SESSION['adresregel2'] = $gebruiker["adresregel2"];
		}
		$_SESSION['postcode'] = $gebruiker["postcode"];
		$_SESSION['plaatsnaam'] = $gebruiker["plaatsnaam"];
		$_SESSION['land'] = $gebruiker["land"];
		$_SESSION['geboortedag'] = $gebruiker["geboortedag"];
		$_SESSION['wachtwoord'] = $gebruiker["wachtwoord"];
		$_SESSION['vraag'] = $gebruiker["vraag"];
		$_SESSION['antwoordtekst'] = $gebruiker["antwoordtekst"];
		$_SESSION['soortGebruiker'] = $gebruiker["soortGebruiker"];			
		header("location: ./user-details.php");
	}
	else {
		$_SESSION['message_login'] = "Verkeerd wachtwoord of onbekende e-mail, probeer opnieuw!";
	}
}

function insertUpgradeinfoInDB(){
	$state = false;


    $username = 'testnaam';
    $bank = $_SESSION['bank'];
    $banknumber = $_SESSION['banknumber'];
    $verificationMethod = $_SESSION['verificationMethod'];
    $creditcardnumber = $_SESSION['creditcardnumber'];

    $insertInfoParam = array(':gebruikersnaam' => $username, ':bank' => $bank, ':rekeningnummer' => $banknumber, ':controleOptie' => $verificationMethod, ':creditcardnumber' => $creditcardnumber);

    $melding = handlequery("INSERT INTO Verkoper VALUES(:gebruikersnaam, :bank, :rekeningnummer, :controleOptie, :creditcardnumber)", $insertInfoParam);

    $parameters = array(':username' => "$username");
    handleQuery("UPDATE Gebruiker
				SET soortGebruiker = 2 
				WHERE gebruikersnaam = :username", $parameters);

    $_SESSION["error_upgrade"] = ' ';
    header("Location: ./user.php");
    //echo '<script>window.location="./user.php";</script>';
}

function sendCode($email, $subjectText, $bodyText, $headerLocationIf, $headerLocationElse, $randomVerificationCode){
	$to      = $email;
	$subject = $subjectText;
	$message_body = $bodyText;

	$randomVerificationCode_hashed = md5($randomVerificationCode);

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		setCodeInDB($email, $randomVerificationCode_hashed);
		sendMail($to, $subject, $message_body, $message);
		header("Location: ./".$headerLocationIf);
		// echo '<script>alert('. $randomVerificationCode .')</script>';
	} else {
		$_SESSION['error_upgrade'] = 'Geen geldig e-mailadres.';
		header("Location: ./". $headerLocationElse);
	}
}

function validateCode($inputCode, $email){		

	$emailParameters = array(':mailadres' => "$email");
	$emailEquivalent = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres",$emailParameters)[0];

	// $emailEquivalent['code'] =  trim($emailEquivalent['code']);
	
	$hashedCode = md5($inputCode); //hashed de code, zodat deze gecontroleerd kan worden met de gesahesde code binnen de database
	
	if ($emailEquivalent['code'] == $hashedCode){
		$state = true;
	} 
	else{
		$state = false;
	}
	return $state;
}
