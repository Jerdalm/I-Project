<?php

function AlterCookie($CookieName, $vwNummer, $vol = false)
{
    echo "dein mutti eins";
    $ItemArray = unserialize($_COOKIE[$CookieName]);
    $month_in_sec = 2592000;
    if (!in_array($_GET['product'], $ItemArray)) {
        if ($vol) {
            echo "vol";
            array_shift($ItemArray);
            array_push($ItemArray, $_GET['product']);
            setcookie($CookieName, serialize($ItemArray), time() + $month_in_sec);
        } else {
            echo "NIETvol";
            array_push($ItemArray, $_GET['product']);
            //voeg cookie toe
            setcookie($CookieName, serialize($ItemArray), time() + $month_in_sec);
        }
    }
}

function MakeCookie($CookieName)
{
    echo "dein mutti zwei";
    $month_in_sec = 2592000;
    $ItemArray = array($_GET['product']);
    setcookie($CookieName, serialize($ItemArray), time() + $month_in_sec);
}

function CheckCookieLengthSmallerThanSix($username)
{
    echo "dein mutti drei";
    $data = unserialize($_COOKIE[$username]);
    if (sizeof($data) < 6) {
        return true;
        echo $data;
    } else {
        return false;
    }
}

function Setquery($username, $vwNummer)
{
    echo "dein mutti vier";
    $data = unserialize($_COOKIE[$username]);

    $datalist = ($data[0] . ',' . $data[1] . ',' . $data[2]. ',' . $data[3] . ',' . $data[4] . ',' . $data[5]);
    echo $datalist;

    $Arrayquery = "SELECT C.*, Vo.plaatsnaam as plaats
                  FROM currentAuction C
                  
                  INNER JOIN voorwerp Vo
                  ON C.voorwerpnummer = Vo.voorwerpnummer
                  
                  INNER JOIN VoorwerpInRubriek V
                  ON V.voorwerpnummer = C.voorwerpnummer
                  
                  WHERE C.voorwerpnummer IN ($datalist)/* cookie voorwerpen */
                  AND C.voorwerpnummer != $vwNummer";/* Waarde huidig nummer */

    print_r($data);
    return $Arrayquery;
}

/* Deze functie zorgt voor de connectie met de Database */
function ConnectToDatabase(){
	$hostname = "localhost";
	$dbname = "iproject34";
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

/* Deze functie handeld elke database query af |Voor elke functie kan voor elke functie gebruikt|*/
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


	// mail( $emailTo, $subjectEmail, $message_body );
    echo '<script> alert("'.$body.'")</script>'; //geeft binnen een alert-box de body aan, wat eigenlijk binnen de mail staat

	$_SESSION['message'] = $message;
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

/* Deze functie checkt of het meegegeven bestand al bestaat */ 
function checkExistingFile($file){
	if (file_exists($file)) {
		echo "Sorry, Het bestand bestaat al.";
		return false;
	} else {
		return true;
	}
}

/* Deze functie checkt of het meegegeven bestandsgrootte niet overschreden worden */
function checkSizeFile($fileSize){
	if ($_FILES["fileToUpload"]["size"] > $fileSize) {
		echo "Sorry, Uw bestand is te groot.";
		return false;
	} else {
		return true;
	}
}

/* Deze functie checkt of het meegegeven bestandstype voldoet aan de eisen */
function checkAllowedFileTypes($imageFileType){
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
		echo "Sorry, alleen JPG, JPEG & PNG files zijn toegestaan.";
		return false;
	} else {
		return true;
	}
}

/* Deze functie checkt of het meegegeven bestand daaderkelijk een plaatje is */
function checkIfImage($file){
	if(isset($file)) {
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		if($check !== false) {
			return true;
		} else {
			echo "File is not an image.";
			return false;
		}
	}
}

/* Deze functie toont tekst en link wordt bepaalt a.d.h.v. of je ingelogt of uitlogt bent */
function showLoginMenu(){
	$htmlLogin = ' ';
	if(isset($_SESSION['gebruikersnaam']) && !empty($_SESSION['gebruikersnaam'])){
		
		$htmlLogin .= '<li class="nav-item"><a class="nav-link" href="./account.php">Account</a></li>';
		$htmlLogin .= '<li class="nav-item"><a class="nav-link" href="./logout.php">Uitloggen</a></li>';

		
	} else {
		$htmlLogin .= '<li class="nav-item"><a class="nav-link" href="./user.php">Inloggen</a></li>';
	}
	return $htmlLogin;
}

/* Deze functie genereert een random code */
function generateRandomCode(){
	return uniqueid(rand(100000,900000),true);
}

/* Deze functie checkt of de username nog niet bestaat, en of de wachtwoorden overeen komen, en aan de regels voldoen */
function checkUsernamePassword($username, $password, $passwordrepeat){
	$passwordMinimumLength = 7;
	$getUserParameters = array(':gebruikersnaam' => $username);
	$getUserQuery =  handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam", $getUserParameters);

	if(count($getUserQuery) > 0) {
		$message_registration = "Uw ingevoerde gebruikersnaam bestaat al";
	} else {
		if ($password == $passwordrepeat) {

			if (strlen($password) >= $passwordMinimumLength && contains_number($password)) {
				$password_hashed = password_hash($password , PASSWORD_DEFAULT);
				$_SESSION['username'] = $username;
				$_SESSION['password'] = $password_hashed;
				header("Location: ./registreren.php?step=4");
			} else if (strlen($password) < $passwordMinimumLength &&  0 === preg_match('~[0-9]~', $password)) {
				$message_registration = "Uw wachtwoord moet minstens 7 tekens bevatten.<br>Uw wachtwoord moet minimaal 1 cijfer bevatten.";
			} else if (strlen($password) < $passwordMinimumLength) {
				$message_registration = "Uw wachtwoord moet minstens 7 tekens bevatten.";
			} else if (0 === preg_match('~[0-9]~', $password)) {
				$message_registration = "Uw wachtwoord moet minimaal 1 cijfer bevatten.";
			}
		} else {
			$message_registration = "De wachtwoorden komen niet overeen";
		}
	}
	return $message_registration;
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
		header('Location: url=./user.php');
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
	$message_login = '';

	if (count($gebruiker) == 0) {
		$message_login = "Verkeerd wachtwoord of onbekende e-mail, probeer opnieuw!";
	} else {
		$wachtwoord = trim($wachtwoord);
		$gebruiker['wachtwoord'] = trim($gebruiker[0]['wachtwoord']);

		if (password_verify($wachtwoord, $gebruiker[0]['wachtwoord']) || $wachtwoord == $gebruiker[0]['wachtwoord']) {

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
			
			redirectJS('account.php');
		}
		else {
			$message_login = "Verkeerd wachtwoord of onbekende e-mail, probeer opnieuw!";
		}
	}
	return $message_login;
}

/* Deze functie zet de gegevens uit de upgrade-formulieren binnen de database */
function insertUpgradeinfoInDB(){
	$state = false;

    $username = $_SESSION['gebruikersnaam'];
	$bank = $_SESSION['bank'];
	$banknumber = $_SESSION['banknumber'];
	$verificationMethod = $_SESSION['verificationMethod'];
	$creditcardnumber = $_SESSION['creditcardnumber'];

	$insertInfoParam = array(':gebruikersnaam' => $username, ':bank' => $bank, ':rekeningnummer' => $banknumber, ':controleOptie' => $verificationMethod, ':creditcardnumber' => $creditcardnumber);

    $parameters = array(':username' => "$username");
    handleQuery("UPDATE Gebruiker
		SET soortGebruiker = 2
		WHERE gebruikersnaam = :username", $parameters);

	$melding = handlequery("INSERT INTO Verkoper VALUES(:gebruikersnaam, :bank, :rekeningnummer, :controleOptie, :creditcardnumber)", $insertInfoParam);

	$_SESSION['soortGebruiker'] = 2;
	header("Location: /account.php");
	exit();
}

/* Deze functie returnt de verschillende rubrieken voor in het submenu */
function showMenuRubrieken($toplevel){
	if($toplevel == null){ $querypart = " is NULL ";}
	else{ $querypart = " = $toplevel";}
	
	$html = '';
	$rubrieken = handlequery("SELECT * from Rubriek where Rubriek.hoofdrubriek ".$querypart."");

	foreach($rubrieken as $rubriek){
		$html .= '<a class="dropdown-item" href="overview.php?rub='.$rubriek['rubrieknummer'].'">'.$rubriek['rubrieknaam'].'</a>';
	}
	return $html;
}

/* Deze functie returnt de rubriekenlijst in submenu's */
/* performanceopties verder zijn:
- image size reducen
- procedure items laten berekenen wanneer gevraagd
- zo min mogelijk query's in loop
- lege rubrieken skippen
*/
function showRubriekenlist($toplevel){
	
	$html = '<ul class="list-group">';
	$rubrieken = FetchSelectData("EXECUTE dbo.SHOW_RUBRIEK_TREE @rubriek = $toplevel");
	$previouslevel = $rubrieken[0]['Lvl'];

	foreach($rubrieken as $rubriek){
		
		if($rubriek['Lvl'] < $previouslevel){
		$lvldif = $previouslevel - $rubriek['Lvl'];
			for($teller = 0; $teller <  $lvldif; $teller++){
			$html .= '</ul>';
			}
		}
		
		$subcata = getSubRubriek($rubriek['rubrieknummer']);
		$amountInRubarr = handlequery("SELECT COUNT(voorwerpnummer) AS productaantal from VoorwerpInRubriek WHERE rubriekOpLaagsteNiveau IN ".$subcata."");
		$amountInRub = $amountInRubarr[0]['productaantal'];
		
		if(!$amountInRub){continue;}
		
		
		$rubriekparameters = array(':rubriek' => $rubriek['rubrieknummer']);
		$subrubrieken = handlequery("SELECT TOP 1 rubrieknummer from dbo.Rubriek where Rubriek.hoofdrubriek = :rubriek",$rubriekparameters);


		if($subrubrieken){
			$html .= '<li class="list-group-item d-flex justify-content-between align-items-center">
			<a href="#'.$rubriek['rubrieknummer'].'" data-toggle="collapse" aria-expanded="false">'.$rubriek['rubrieknaam'].'
			<span class="badge badge-primary badge-pill">'.$amountInRub.'</span>
			<i class="fa fa-angle-down"></i>

			</a></li>
			<ul class="collapse subnav-'.$rubriek['Lvl'].' list-unstyled" id="'.$rubriek['rubrieknummer'].'">';
		}
		else{
			$html .=
			'<li class="list-group-item d-flex justify-content-between align-items-center ">
			<a href="overview.php?rub='.$rubriek['rubrieknummer'].'">'.$rubriek['rubrieknaam'].'
			<span class="badge badge-primary badge-pill">'.$amountInRub.'</span>
			</a></li>';
		}

		$previouslevel = $rubriek['Lvl'];

		if ($rubriek === end($rubrieken)){
			if($rubriek['Lvl'] > 1){
				$html .= '</ul>';
			}
		}
	}
	$html .= '</ul>';
	return $html;
}


/* Deze functie toont alle producten  || Filterwaarde ('afstand','false')*/
function showProducts($carrousel = false, $query = false, $parameters = false, $showAccount = false, $lg = 4, $md = 6, $sm = 6, $xs = 12){

	if( is_array($query)){
		$producten = $query;
	}
	else{

		if($query == false){
			$query = "SELECT * from currentAuction";
		}

		if($parameters){
			$producten = handlequery($query,$parameters);

		}

		else{
			$producten = handlequery($query);

		}
	}
	
	if($producten){
	$beforeInput = '';
	$afterInput = '';
	$html = '';
	$itemcount = 0;

	if($carrousel){
		$beforeFirstInput = '<div class="carousel-item col-lg-'.$lg.' col-md-'.$md.' col-sm-'.$sm.' col-xs-'.$xs.' active">';
		$beforeInput = '<div class="carousel-item col-lg-'.$lg.' col-md-'.$md.' col-sm-'.$sm.' col-xs-'.$xs.'">';
		$afterInput = '</div>';
	}
	else{
		$beforeInput = '<div class="col-lg-'.$lg.' col-md-'.$md.' col-sm-'.$sm.' col-xs-'.$xs.'">';
		$afterInput = '</div>';
	}

	foreach($producten as $product) {

        $itemcount++;
        if (!$product['bodbedrag']) {
            $product['bodbedrag'] = 0;
        }

        if ($carrousel) {
            if ($itemcount == 1) {
                $html .= $beforeFirstInput;
            } else {
                $html .= $beforeInput;
            }
        } else {
            $html .= $beforeInput;
        }

        $timediff = calculateTimeDiffrence(date('Y-m-d h:i:s'),
            $product['einddag'] . ' ' . $product['eindtijdstip']
        );

        $html .= '
		<div class="product card">
		<img class="card-img-top img-fluid" src="img/products/' . $product['bestand'] . '" alt="">
		<div class="card-body">
		<h4 class="card-title">
		' . $product['titel'] . '
		</h4>';

		if ($showAccount == false) {
            $html .= '<h5 class="product-data" id = "' . $product['voorwerpnummer'] . '" ><span class="time" > ' . $timediff . '</span >|<span class="price" >&euro;' . $product['bodbedrag'] . ' </span ></h5 >';
		}

		$html.='
		<a href="productpage.php?product='.$product['voorwerpnummer'].'" class="btn cta-white">Bekijk nu</a>
		</div>
		<div class="card-footer text-center text-muted">
		locatie: '.$product['plaats'].'
		</div>
		</div>
		';
		$html .= $afterInput;
	}}
	else{$html = '<div class="col-lg-12 text-center"><h4> Geen producten gevonden </h4></div>';}
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

/* returnt een array met de rubrieken in breadcrumb layout |Gebruik dit in combinatie met de procedure SHOW_RUBRIEK_TREE|
*/
function getRubriekPath($array, $arrayregel){

	$currentlevel = $array[$arrayregel]['Lvl'];
	$currentRubriek = $array[$arrayregel]['rubrieknaam'];
	$currentNumber= $array[$arrayregel]['rubrieknummer'];
	$results = array(array($currentRubriek,$currentNumber));


	if($currentlevel > 1){
		while($currentlevel > 1){
			$arrayregel--;

			if($array[$arrayregel]['Lvl'] < $currentlevel){
				$results[] = array($array[$arrayregel]['rubrieknaam'],$array[$arrayregel]['rubrieknummer']);
				$currentlevel --;
			}
		}
	}

	$rubrieken = array_reverse($results);
	return $rubrieken;
}

/* Maak rubriek breadcrumb aan de hand van de data */

function createRubriekBreadcrumb($array){
	$html = '';

	foreach($array as $value){


		if( !next( $array ) ) {
			$html .=  '<li class="breadcrumb-item">'.$value[0].'</li>';
		}
		else{
			$html .=  '<li class="breadcrumb-item"><a href="overview.php?rub='. $value[1].'">'. $value[0].'</a></li>';
		}

	}
	return $html;
}

/* Returnt het rubrieknummer van de huidige rubriek en de subrubrieken */
function getSubRubriek($rubrieknumber){
	$rubriekparameters = array(':rubriek' => $rubrieknumber);
	$rubrieken = FetchSelectData("EXEC SHOW_RUBRIEK_TREE @rubriek = :rubriek",$rubriekparameters);


	$rubrieknumbers = array_column($rubrieken, 'rubrieknummer');
	if($rubrieknumbers){
		return '(' . implode(',', $rubrieknumbers) .')';
	}
}

function deleteUser($gebruiker){
	$deleteParam = array(':gebruikersnaam' => $gebruiker);
	handlequery("UPDATE Gebruiker SET soortGebruiker=3 WHERE gebruikersnaam=:gebruikersnaam",$deleteParam);
}

function deleteArticle($artikel){
	$deleteParam = array(':artikel' => $artikel);
	handlequery("DELETE FROM Voorwerp WHERE voorwerpnummer = :artikel", $deleteParam);
}

/* In deze functie wordt de afstand in tijd en km berekend tussen 2 locaties|Invoer: stad/dorp/postcode */
function getDistanceData($cityUser,$citySeller){
	$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=".$cityUser."&destinations=".$citySeller."&language=nl-NL&sensor=false");
	$data = json_decode($data, true);

	$time = $data['rows'][0]['elements'][0]['duration']['text']; //Text for String and Value for INT
	$distance = $data['rows'][0]['elements'][0]['distance']['value'];//Text for String and Value for INT
	$distanceKm = round($distance / 1000);

	return array('time' => $time, 'distance' => $distanceKm);
}

	// returnt parameter array
function checkPriceFilter($min, $max){

	$returnwaarde = '1 = 1';

	if(!empty($min) && !empty($max)){
		if(is_numeric($min) && is_numeric($max)){
			$returnwaarde = "bodbedrag between $min AND $max";
		}
	}


	return $returnwaarde;
}

function UpdateInfoUser($get, $gebruikersnaam,$gebruiker,$telefoonnummers){
	
	$birthdate = $get['geboortedag'];
	$myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
	$geboortedag = $myDateTime->format('Y-m-d');

	$infoParameters = array(':gebruikersnaam' => $gebruikersnaam ,
		':voornaam' => $get['voornaam'],
		':achternaam' => $get['achternaam'] ,
		':adresregel1' => $get['adresregel1'] ,
		':adresregel2' => $get['adresregel2'] ,
		':postcode' => $get['postcode'],
		':plaatsnaam' => $get['plaatsnaam'] ,
		':land' =>  $get['land'] ,
		':geboortedag' => $geboortedag ,
		':mailadres' => $get['mailadres']);
	handlequery("UPDATE Gebruiker
		SET voornaam = :voornaam ,
		achternaam = :achternaam,
		adresregel1 = :adresregel1 ,
		adresregel2 = :adresregel2 ,
		postcode = :postcode,
		plaatsnaam = :plaatsnaam ,
		land = :land,
		geboortedag = :geboortedag,
		mailadres = :mailadres
		WHERE gebruikersnaam = :gebruikersnaam",
		$infoParameters);

	if( $nummer['volgnr'] == null ){
		
		$telefoonnummerPara = array(':telefoonnummer' => $get['telefoonnummer0'] , ':gebruikersnaam' => $gebruikersnaam);
		handlequery("INSERT INTO Gebruikerstelefoon (telefoonnummer,gebruikersnaam) VALUES (:telefoonnummer,:gebruikersnaam )",$telefoonnummerPara);
		
	}  else {
		handlequery("UPDATE Gebruikerstelefoon
		SET telefoonnummer = :telefoonnummer
		WHERE gebruikersnaam = :gebruikersnaam" , $telefoonnummerPara);
	}

	if($gebruiker['telefoonnummer'] == null){
		
	} else {
		handlequery("UPDATE Gebruikerstelefoon
		SET telefoonnummer = :telefoonnummer
		WHERE gebruikersnaam = :gebruikersnaam" , $telefoonnummerPara);
	}
	echo '<script>window.location.replace("./account.php")</script>';
}

/* toont goede button aan de hand van ingelogt zijn of niet */
function showButtonIndex(){
	if(isset($_SESSION['gebruikersnaam'])){
		if($_SESSION['soortGebruiker'] != 2) {
		echo '<a href="upgrade-user.php" class="cta-orange">Wordt verkoper!</a>';
	} else {
		echo '<a href="upload-article.php" class="cta-orange">Verkoop voorwerp!</a>';
	}
	} else {
		echo '<a href="registreren.php" class="cta-orange">Registreer je nu om mee te bieden!</a>';		
	}
}

function checkNewPassword ($password, $passwordrepeat){
	$passwordMinimumLength = 7;
	$messageReturn = '';
	if ($password == $passwordrepeat) {
		if (strlen($password) >= $passwordMinimumLength && contains_number($password)) {
			$password_hashed = password_hash($password , PASSWORD_DEFAULT);	
			$_SESSION['password'] = $password_hashed;
			$messageReturn = "Wachtwoord zit in de database";												
		} else if (strlen($password) < $passwordMinimumLength &&  0 === preg_match('[0-9]', $password)) {
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

	function pagination($array,$itemsperpage = 10){
		$submenus =(sizeof($array) / $itemsperpage);
		$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		if(isset($_GET['pagination'] ) && isset($_GET['perpage'] )){
			$currentpagination = '&pagination='.$_GET['pagination'].'&perpage='.$_GET['perpage'];
			$newUrl = str_replace($currentpagination, '', $actual_link);
		}else{$newUrl = $actual_link; }
		
		$url_end = substr($actual_link, -3);
		if($url_end == 'php'){$newUrl = $newUrl.'?';}
		
		if($submenus > 1){
			
			for($teller = 0; $teller < $submenus; $teller++){
				$startvalue = $teller * $itemsperpage;
				$visueel = $teller + 1;
				
				echo "<a class=\"btn btn3 \" href=\"$newUrl&pagination=$startvalue&perpage=$itemsperpage\">$visueel</a>";	
			}
		}		
	}
	
	function logUserHistory($cookieName){

	}
	
	function redirectJS($url){
		echo '<script>window.location.href = "'.$url.'"</script>';
	}
	
?>
