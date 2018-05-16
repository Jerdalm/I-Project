<?php

/* Deze functie zorgt voor de connectie met de Database */	
function ConnectToDatabase(){
	$hostname = "(local)";
	$dbname = "iproject34";
	$dbusername = "sa";
	$dbpw = "12345";

	try {
		$pdo = new PDO("sqlsrv:Server=$hostname;Database=$dbname;
			ConnectionPooling=0", "$dbusername", "$dbpw");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	} catch(PDOException $e) {
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

function FetchAssocSelectData($sql, $parameters = false){
	global $pdo;
	$qry = $pdo->prepare("$sql");	

	if($parameters){

		$qry->execute($parameters);
	}else{$qry->execute();}

	$result = $qry->fetch(PDO::FETCH_ASSOC);
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

	/* Deze functie verzend een mail naar de aangegeven parameters */
function sendMail($to, $subject, $body, $message = "Fout"){
		$emailTo      = $to;
		$subjectEmail = $subject;
		$message_body = $body;
		echo '<script> alert("'.$body.'")</script>'; //geeft binnen een alert-box de body aan, wat eigenlijk binnen de mail staat
}

/* Creeert een random wachtwoord */
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

/* Deze functie geeft true of fasle terug, a.d.h.v. de POST informatie */
function checkIfFieldsFilledIn(){ // returnt true als de meegegeven velden gevuld zijn 
	if (count(array_filter($_POST)) == count($_POST)) {
		return true;
	} else {			
		return false;
	}
}

/* Deze functie checkt of de velden binnen de  meegegeven array
allemaal ingevult zijn */
function fieldsFilledIn($array){
	foreach ($array as $field) {
		if (!empty($_POST[$field])){
			$state = true;
		} else {
			$state = false;
			break;
		}
	}
	return $state;
}

/* Deze functie controleert of de meegegeven email nog niet bestaat
binnen het gebruikerstabel */
function checkEmailUnique($emailCheck){
	$emailControl = handleQuery("SELECT * FROM Gebruiker WHERE mailadres = :mailadres",array(':mailadres' => $emailCheck));
	
	if(count($emailControl) == 0) {
		$state = true;
	} else {
		$state = false;
	}
	return $state;
}

/* Deze functie checkt of de meegegeven invoer alleen uit karakters bestaat */
function is_Char_Only($Invoer){
	return (bool)(preg_match("/^[a-zA-Z ]*$/", $Invoer)) ;
}

/* Deze functie checkt of er in de meegegeven invoer een getal zit */ 
function contains_number($string){
	return 1 === preg_match('~[0-9]~', $string);
}

/* Deze functie checkt of er in de meegegeven invoer een hoofdletter zit */
function contains_capital($string){
	return preg_match('/[A-Z]/', $string);
}

/* Deze functie toont tekst en link wordt bepaalt a.d.h.v. of je ingelogt of uitlogt bent */		
function showLoginMenu(){
	$htmlLogin = ' ';
	if(isset($_SESSION['gebruikersnaam']) && !empty($_SESSION['gebruikersnaam'])){ 
		$htmlLogin = '<li class="nav-item">';
		$htmlLogin .= '<a class="nav-link" href="./logout.php">Uitloggen</a>';
		$htmlLogin .= '</li>';
	} else {
		$htmlLogin = '<li class="nav-item">';
		$htmlLogin .= '<a class="nav-link" href="./user.php">Inloggen</a>';
		$htmlLogin .= '</li>';
	}
	return $htmlLogin;
}

/* Deze functie genereert een random code */
function generateRandomCode(){
	return uniqueid(rand(100000,900000),true);
}

/* Deze functie checkt of de username nog niet bestaat,
   en of de wachtwoorden overeen komen, en aan de 
   regels voldoen */
function checkUsernamePassword($username, $password, $passwordrepeat){
	$messageReturn = ' ';
	$getUserParameters = array(':gebruikersnaam' => $username);
	$getUserQuery =  handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam", $getUserParameters);

	if(count($getUserQuery) > 0) {
		$messageReturn = "Uw ingevoerde gebruikersnaam bestaat al";
	} else {
		if(checkNewPassword($password, $passwordrepeat) == "Wachtwoord zit in de database"){
			header("Location: ./registreren.php?step=4");
		} else {
			$messageReturn = checkNewPassword($password, $passwordrepeat);
		}
	}
	return $messageReturn;
}

// Deze functie word gebruikt bij het checken of de nieuwe wachtwoord aan de eisen voldoet als de gebruiker zijn wachtwoord wilt wijzigen.
function checkNewPassword($password, $passwordrepeat){
	$passwordMinimumLength = 7;
	$messageReturn = '';
	if ($password == $passwordrepeat) {
		if (strlen($password) >= $passwordMinimumLength && contains_number($password)) {
			$password_hashed = password_hash($password , PASSWORD_DEFAULT);	
			$_SESSION['password'] = $password_hashed;
			$messageReturn = "Wachtwoord zit in de database";												
		} else if (strlen($password) < $passwordMinimumLength &&  0 === preg_match('~[0-9]~', $password)) {
			$messageReturn = "Uw wachtwoord moet minstens 7 tekens bevatten.<br>Uw wachtwoord moet minimaal 1 cijfer bevatten.";	
		} else if (strlen($password) < $passwordMinimumLength) {
			$messageReturn = "Uw wachtwoord moet minstens 7 tekens bevatten.";	
		} else if (!contains_number($password)) {
			$messageReturn = "Uw wachtwoord moet minimaal 1 cijfer bevatten.";
		}
	} else {
		$messageReturn = "De wachtwoorden komen niet overeen";
	}
	return $messageReturn;
}

/* Deze functie zet de registratieinformatie ook daadwerkelijk
in de database */
function insertRegistrationinfoInDB(){
	$voornaam = $_POST['firstname'];
	$achternaam = $_POST['lastname'];
	$adresregel1 = $_POST['adres1'];
	if(isset($_POST['adres2'])){
		$adresregel2 = $_POST['adres2'];
	} else {
		$adresregel2 = NULL;
	}
	$postcode = $_POST['postalcode'];
	$plaatsnaam = $_POST['residence'];
	$land = $_POST['country'];
	$telefoonnummer = $_POST['phonenumber'];
	$birthdate = $_POST['birthdate'];
	$myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
	$geboortedag = $myDateTime->format('Y-m-d');
	$vraag = $_POST['secretquestion'];
	$antwoordtekst = $_POST['secretanswer'];

	if(is_numeric($telefoonnummer)){
		$insertInfoParam = array(':gebruikersnaam' => $_SESSION['username'], 
			':voornaam' => $voornaam, 
			':achternaam' => $achternaam,
			':adresregel1' => $adresregel1, 
			':adresregel2' => $adresregel2, 
			':postcode' => $postcode, 
			':plaatsnaam' => $plaatsnaam, 
			':land' => $land, 
			':geboortedag' => $geboortedag,
			':mailadres' => $_SESSION['email-registration'], 
			':password' => $_SESSION['password'], 
			':vraag' => $vraag, 
			':antwoordtekst' => $antwoordtekst);

		$insertInfoQuery = handlequery("INSERT INTO Gebruiker VALUES(:gebruikersnaam, 
			:voornaam, 
			:achternaam, 
			:adresregel1, 
			:adresregel2, 
			:postcode, 
			:plaatsnaam, 
			:land, 
			:geboortedag, 
			:mailadres, 
			:password, 
			:vraag,
			:antwoordtekst, 
			1)", $insertInfoParam);

		$insertTelParam = array(':gebruikersnaam' => $_SESSION['username'], ':telefoonnummer' => $telefoonnummer);

		$insertTelQuery = handlequery("INSERT INTO gebruikerstelefoon VALUES(:gebruikersnaam, :telefoonnummer)", $insertTelParam);

		session_destroy();
		$message_registration = 'Registratie voltooit!';
		header('Location: ./user.php');
	} else {
		$message_registration = 'Het opgegeven telefoonnummer klopt niet.';
	}
	return $message_registration;
}

/* Deze functie zet de code in de database */
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

/* Deze functie verzendt de code naar de klant (email) */
function sendCode($email, $subjectText, $bodyText, $headerLocationIf, $headerLocationElse, $randomVerificationCode){
	$to      = $email;
	$subject = $subjectText;
	$message_body = $bodyText;

	$randomVerificationCode_hashed = md5($randomVerificationCode);

	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		setCodeInDB($email, $randomVerificationCode_hashed);
		sendMail($to, $subject, $message_body, $message);
		header("Location: ./".$headerLocationIf);      
	} else {
		$_SESSION['error_upgrade'] = 'Geen geldig e-mailadres.';
		header("Location: ./". $headerLocationElse);
	}
}

/* Deze functie controleert of de email en wachtwoord kloppen */
function loginControl($email, $wachtwoord){
	$emailParam = array(':mailadres'=>$email);
	$gebruiker = handleQuery("SELECT * FROM Gebruiker WHERE mailadres=:mailadres", $emailParam);

	if (count($gebruiker) == 0) {
		$message_login = 'Er bestaat geen account met het opgegeven mailadres';
	} else {
		$wachtwoord = trim($wachtwoord);
		$gebruiker['wachtwoord'] = trim($gebruiker[0]['wachtwoord']);

		if (password_verify($wachtwoord, $gebruiker[0]['wachtwoord']) || $wachtwoord == $gebruiker[0]['wachtwoord']) {

			if($email == "admin@root.com"){
				$_SESSION['gebruikersnaam'] = $gebruiker[0]["gebruikersnaam"];
				header("Location: ./admin-pagina.php");
			} else {

				$_SESSION['email'] = $gebruiker[0]["mailadres"];
				$_SESSION['gebruikersnaam'] = $gebruiker[0]["gebruikersnaam"];
				$_SESSION['voornaam'] = $gebruiker[0]["voornaam"];
				$_SESSION['achternaam'] = $gebruiker[0]["achternaam"];
				$_SESSION['adresregel1'] = $gebruiker[0]["adresregel1"];
				if(!empty($gebruiker[0]['adresregel2'])){
					$_SESSION['adresregel2'] = $gebruiker[0]["adresregel2"];
				}
				$_SESSION['postcode'] = $gebruiker[0]["postcode"];
				$_SESSION['plaatsnaam'] = $gebruiker[0]["plaatsnaam"];
				$_SESSION['land'] = $gebruiker[0]["land"];
				$_SESSION['geboortedag'] = $gebruiker[0]["geboortedag"];
				$_SESSION['wachtwoord'] = $gebruiker[0]["wachtwoord"];
				$_SESSION['vraag'] = $gebruiker[0]["vraag"];
				$_SESSION['antwoordtekst'] = $gebruiker[0]["antwoordtekst"];
				$_SESSION['soortGebruiker'] = $gebruiker[0]["soortGebruiker"];			
				header("location: ./user-details.php");
			}
		} else {
			$message_login = "Verkeerd wachtwoord of onbekende e-mail, probeer opnieuw!";
		}
	}
	return $message_login;
}

/* Deze functie zet de gegevens uit de upgrade-formulieren binnen de database */
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

	header("Location: ./index.php", false);
}

/* Deze functie returnt de verschillende rubrieken voor in het submenu */
function showMenuRubrieken(){
	$html = '';
	$rubrieken = handlequery("SELECT * from Rubriek where Rubriek.rubriek is NULL");

	foreach($rubrieken as $rubriek){
		$html .= '<a class="dropdown-item" href="overview.php?rub='.$rubriek['rubrieknummer'].'">'.$rubriek['rubrieknaam'].'</a>';
	}
	return $html;
}

/* Deze functie returnt de rubriekenlijst in submenu's */
function showRubriekenlist(){

	$html = '<ul class="list-group">';
	$rubrieken = FetchSelectData("EXEC SHOW_RUBRIEK_TREE @rubriek = null");
	$previouslevel = $rubrieken[0]['Lvl'];
	foreach($rubrieken as $rubriek){
		$rubriekparameters = array(':rubriek' => $rubriek['rubrieknummer']);
		$subrubrieken = handlequery("SELECT * from Rubriek where Rubriek.rubriek = :rubriek",$rubriekparameters);

		if($rubriek['Lvl'] < $previouslevel){
			$html .= '</ul>';
		}
		if($subrubrieken){
			$html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
			<a href="#'.$rubriek['rubrieknummer'].'" data-toggle="collapse" aria-expanded="false">'.$rubriek['rubrieknaam'].'
			<span class="badge badge-primary badge-pill">14</span>
			</a></li>
			<ul class="collapse list-unstyled" id="'.$rubriek['rubrieknummer'].'">';
		}
		else{
			$html .= 
			'<li class="list-group-item d-flex justify-content-between align-items-center ">
			<a href="overview.php?rub='.$rubriek['rubrieknummer'].'">'.$rubriek['rubrieknaam'].'
			<span class="badge badge-primary badge-pill">14</span>
			</a></li>';
		}
		$Previouslevel = $rubriek['Lvl'];
	}
	$html .= '</ul>';
	return $html;
}

/* Deze functie toont alle producten */
function showProducts($carrousel = false, $query = false){
	if($query == false){
		$query = "SELECT * from currentAuction";
	}
	$producten = handlequery($query);
	$beforeInput = '';
	$afterInput = '';
	$html = '';
	$itemcount = 0;
	if($carrousel){
		$beforeFirstInput = '<div class="carousel-item col-lg-4 col-md-6 col-sm-6 col-xs-12 active">';
		$beforeInput = '<div class="carousel-item col-lg-4 col-md-6 col-sm-6 col-xs-12">';
		$afterInput = '</div>';
	}
	else{
		$beforeInput = '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">';
		$afterInput = '</div>';
	}

	foreach($producten as $product)
	{
		$itemcount++;
		if(!$product['bodbedrag']){
			$product['bodbedrag'] = 0;
		}

		if($carrousel){
			if($itemcount == 1){
				$html .= $beforeFirstInput;
			}
			else{$html .= $beforeInput;}
		}
		else{
			$html .= $beforeInput;
		}

		$timediff = calculateTimeDiffrence(date('Y-m-d h:i:s'),
			$product['einddag'].' '.$product['eindtijdstip']
		);

		$html .= '
		<div class="product card">
		<img class="card-img-top img-fluid" src="img/products/'.$product['bestand'].'" alt="">
		<div class="card-body">
		<h4 class="card-title">
		'.$product['titel'].'
		</h4>
		<h5 class="product-data"><span class="time">'.$timediff.'</span>|<span class="price">&euro;'.$product['bodbedrag'].'</span></h5>
		<a href="productpage.php?product='.$product['voorwerpnummer'].'" class="btn cta-white">Bekijk nu</a>
		</div>
		</div>
		';
		$html .= $afterInput;
	}
	/* Returns product cards html */
	return $html;
}

/* Deze functie berekend het verschil tussen 2 data */
function calculateTimeDiffrence($timestamp1, $timestamp2){

	$datetime1 = new DateTime($timestamp1);//start time
	$datetime2 = new DateTime($timestamp2);//end time
	$interval = $datetime1->diff($datetime2);

	return $interval->format('%d dagen <br> %H:%i:%s uur');
} 

/* Deze functie checkt of de code klopt met wat er in de database staat*/
function validateCode($inputCode, $email){		
	$emailParameters = array(':mailadres' => "$email");
	$emailEquivalent = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres",$emailParameters)[0];
	// $emailEquivalent['code'] =  trim($emailEquivalent['code']);
	$hashedCode = md5($inputCode); //hashed de code, zodat deze gecontroleerd kan worden met de gesahesde code binnen de database

	if ($emailEquivalent['code'] == $hashedCode){
		$state = true;
	} else {
		$state = false;
	}
	return $state;
}

/* Deze functie verwijdert de meegegeven gebruiker uit de database */
function deleteUser($gebruiker){
	$deleteParam = array(':gebruikersnaam' => $gebruiker);
	handlequery("UPDATE Gebruiker SET soortGebruiker=3 WHERE gebruikersnaam=:gebruikersnaam",$deleteParam);
}

function deleteArticle($artikel){
	$deleteParam = array(':artikel' => $artikel);
	handlequery("DELETE FROM Voorwerp WHERE voorwerpnummer = :artikel", $deleteParam);
}
