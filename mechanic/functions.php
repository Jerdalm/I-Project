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

	function checkIfFieldsFilledIn($fields){ // returnt true als de meegegeven velden gevuld zijn 
		$fieldfilled = false;
		// echo '<pre>';
		// print_r($fields);
		// echo '</pre>';
		// die();
		if($fields){
			foreach($fields as $field) {
			  if (empty($field)) {
			  	$fieldfilled = false;
				break;

			  } else {			
				// echo "Ik kom hier naar voren";
				// die();
			  	$fieldfilled = true;			  			 
			  }
			return $fieldfilled;
			}		
		} else { 			
		}
	}


	function sendRegistrationCode($emailCheck){
		// $randomVerificationCode = uniqueid(rand(100000,900000), true);
		$randomVerificationCode = 111111;
		$emailControl = handleQuery("SELECT * FROM Gebruiker WHERE mailadres = :mailadres",array(':mailadres' => $emailCheck));

		$to      = $emailCheck;
		$subject = 'Account activatie';
		$message_body = '
		Beste,

		Bedankt voor het registreren!

		Voer deze code in op de site:
		' . $randomVerificationCode .'.';
		$message = 'Er is een email met de verificatiecode naar het opgegeven emailadres gestuurt.';

		$randomVerificationCode_hashed = md5($randomVerificationCode);

		$_SESSION['code'] = $randomVerificationCode; 	
		if(count($emailControl) == 0) {
		    if (filter_var($emailCheck, FILTER_VALIDATE_EMAIL)) {
		    	
		    	setCodeInDB($emailCheck, $randomVerificationCode_hashed);

		        sendMail($to, $subject, $message_body, $message);
		        header("Location: ./user.php?step=2");
		        // echo '<script>alert('. $randomVerificationCode .')</script>';
		    } else {
		        $_SESSION['error_registration'] = 'Geen geldig e-mailadres.';
		        header("Location: ./index.php");
		    }
		} else {
			header("Location: ./index.php");
		}
		
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

	function validateCode($inputCode, $email_registration){		

		$emailParameters = array(':mailadres' => "$email_registration");
		$emailEquivalent = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres",$emailParameters)[0];
     	
		// $emailEquivalent['code'] =  trim($emailEquivalent['code']);
		
		$hashedCode = md5($inputCode); //hashed de code, zodat deze gecontroleerd kan worden met de gesahesde code binnen de database
		
		if ($emailEquivalent['code'] == $hashedCode){
		    header("Location: ./user.php?step=3");
		} 
		else{
			$_SESSION['error_registration'] = 'De code klopt niet, probeer opnieuw!'; 
			header("Location: ./user.php?step=2");
			
		}
	}

	function checkUsernamePassword($username, $password, $passwordrepeat){
		// echo "aanwezig";
		// die();
		if ($password != $passwordrepeat) {
		    $_SESSION['error_registration'] = "de wachtwoorden komen niet overeen";
		    header("Location: ./user.php?step=3");
		} else {		   
		    $getUserParameters = array(':gebruikersnaam' => $username);
		    $getUserQuery =  handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam", $getUserParameters);

		    if(count($getUserQuery) > 0) {
		        $_SESSION['error_registration'] = "uw ingevoerde gebruikersnaam bestaat al";
		        header("Location: ./user.php?step=3");
		    } else {
		        $_SESSION['username'] = $username;
		        $_SESSION['password'] = $password;

		        $_SESSION["error_registration"] = '';
		        header("Location: ./user.php?step=4");
		    }
		}
	}


	function insertRegistrationnfoInDB(){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$adres1 = $_POST['adres1'];
		$adres2 = $_POST['adres2'];
		$postalcode = $_POST['postalcode'];
		$residence = $_POST['residence'];
		$country = $_POST['country'];
		$phonenumber = $_POST['phonenumber'];
		$birthdate = $_POST['birthdate']; //deze snap ik niet

		$date = $_POST['birthdate']; //deze snap ik niet
		// $date = DateTime::createFromFormat('j-M-Y', $_POST['birthdate']);		
		
		$myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
		$birthdate = $myDateTime->format('Y-m-d');

		$secretquestion = $_POST['secretquestion'];
		$secretanswer = $_POST['secretanswer'];

		// voer query uit in de database voor tabel gebruikers

		// $query1parameters = array(':gebruikersnaam' => $_SESSION['username']);
		// $query1 = handlequery("SELECT gebruikersnaam FROM Gebruiker WHERE gebruikersnaam = :username", $query1parameters);

		// $query2 = handlequery("INSERT INTO Gebruiker VALUES", $query1parameters);		
		$insertInfoParam = array(':gebruikersnaam' => $_SESSION['username'], ':voornaam' => $firstname, 'achternaam' => $lastname, 'adresregel1' => $adres1, 'adresregel2' => $adres2, 'postcode' => $postalcode, 'plaatsnaam' => $residence, 'land' => $country, 'geboortedag' => $birthdate, 'mailadres' => $_SESSION['email-registration'], 'vraag' => $secretquestion, 'antwoordtekst' => $secretanswer);
	    
	    handlequery("INSERT INTO Gebruiker VALUES(:gebruikersnaam, :firstname, :lastname, :adres1, :adres2, :postalcode, :residence, :country, :phonenumber, :birthdate, :mailadres, :secretquestion, :secretanswer, 1)", $insertInfoParam);

	    $insertTelParam = array(':gebruikersnaam' => $_SESSION['username'], ':telefoonnummer' => $phonenumber);

	    handlequery("INSERT INTO gebruikerstelefoon VALUES(:gebruikersnaam, :telefoonnummer)", $insertTelParam);

	    session_destroy();
	    header('Refresh:0; url=./user.php');
	    $_SESSION["error_registration"] = ' ';

	}
?>

