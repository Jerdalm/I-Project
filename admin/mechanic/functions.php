<?php

/* Deze functie zorgt voor de connectie met de Database */
function ConnectToDatabase(){
	$hostname = "(local)";
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

	$result = $qry->fetchAll();

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


    //mail( $emailTo, $subjectEmail, $message_body ); moet uiteindelijk wel aan!
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

/* Deze functie toont tekst en link wordt bepaalt a.d.h.v. of je ingelogt of uitlogt bent */
function showLoginMenu(){
	$htmlLogin = ' ';
	if(isset($_SESSION['gebruikersnaam']) && !empty($_SESSION['gebruikersnaam'])){
		$htmlLogin = '<li class="nav-item">';
		$htmlLogin .= '<a class="nav-link" href="./admin-pagina.php">Beheerder</a>';
		$htmlLogin .= '</li>';
		$htmlLogin .= '<li class="nav-item">';
		$htmlLogin .= '<a class="nav-link" href="./logout.php">Uitloggen</a>';
		$htmlLogin .= '</li>';
	} else {
		$htmlLogin = '<li class="nav-item">';
		$htmlLogin .= '<a class="nav-link" href="./user.php">Inloggen</a>';
		$htmlLogin .= '</li>';
	}
	return $htmlLogin;
}
/* Deze functie blokkeerd de meegegeven gebruiker uit de database */
function blockUser($gebruiker){
	$deleteParam = array(':gebruikersnaam' => $gebruiker);
	handlequery("UPDATE Gebruiker SET soortGebruiker=3 WHERE gebruikersnaam=:gebruikersnaam",$deleteParam);
}

/* Deze functie verwijderd het meegegeven artikel uit de database */
function deleteArticle($artikel){
	$deleteParam = array(':artikel' => $artikel);
	handlequery("DELETE FROM Voorwerp WHERE voorwerpnummer = :artikel", $deleteParam);
}

function changedFields($fieldsOld, $fieldsNew){
	$state = false;
	foreach ($fieldsOld as $indexOld) {
		foreach ($fieldsNew as $indexNew) {
			if ($indexNew == $indexOld) {
				$state = false;
				break;
			} else {
				$state = true;
			}
		}
	}
	return $state;
}


?>
