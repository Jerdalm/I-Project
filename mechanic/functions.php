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

<<<<<<< HEAD
	/* Deze functie stuurt een verificatiecode naar de opgegeven emaildres */
	function sendCode($randomNumber, $email){
	    $_SESSION['active'] = 0; //0 until user activates their account with verify.php
	    $_SESSION['message'] =
	            
	             "Er is een verficatiecode naar $email gestuurd, 
	              voer de code in om het account te activeren!";
	    
	    $to      = $email;
	    $subject = 'Account activatie';
	    $message_body = '
	    Beste,
=======
	function sendMail($to, $subject, $body, $message = "Fout"){
		$emailTo      = $to;
	    $subjectEmail = $subject;
	    $message_body = $body;

>>>>>>> a63c69ba4ee1635cdc539b699cfdeefbee5bcf8e

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

<<<<<<< HEAD
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
=======
>>>>>>> a63c69ba4ee1635cdc539b699cfdeefbee5bcf8e
} 
?>



