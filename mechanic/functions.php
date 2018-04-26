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


	/* Deze functie stuurt een verificatiecode naar de opgegeven emaildres */
	function sendCode($randomNumber, $email){
	    $_SESSION['message'] =
	            
	             "Er is een verficatiecode naar $email gestuurd, 
	              voer de code in om het account te activeren!";
	    
	    $to      = $email;
	    $subject = 'Account activatie';
	    $message_body = '
	    Beste,

	    Bedankt voor het registreren!

	    Voer deze code in op de site:
	    ' .$randomNumber.'.';

	    // mail( $to, $subject, $message_body ); moet uiteindelijk wel aan!

        $_SESSION["step1"] = false;
        $_SESSION["step2"] = true;
        header("location: ./registratieScherm.php");

    }
?>

