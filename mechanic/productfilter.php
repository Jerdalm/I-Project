<?php 	

	/* Wanneer er op prijs word gezocht */
	if(isset($_GET['min']) && isset($_GET['max'])){
	$pricecheck = checkPriceFilter($_GET['min'],$_GET['max']);
	}
	else{
	$pricecheck = checkPriceFilter(null,null);
	}
	
	/* Wanneer er op rubriek word gezocht */
	if(isset($_GET['rub'])){ 
	$rubriek = $_GET['rub'];
	
	if(is_numeric($rubriek)){
	$rubriekdata = getSubRubriek($rubriek);
	
	
	if(!$rubriekdata){$rubriekdata = '('.$rubriek.')';}
	$parameters = false;

	$query = "SELECT TOP 9 * from currentAuction 
	INNER JOIN VoorwerpinRubriek
	ON VoorwerpinRubriek.voorwerpnummer = currentAuction.voorwerpnummer
	Where rubriekOpLaagsteNiveau IN ".$rubriekdata. " AND ".$pricecheck."
	";
	
	$rubrieken = FetchSelectData("EXEC SHOW_RUBRIEK_TREE");
	
	$rubriekparameters = array(':rubriek' => $rubriek);
	$rubriekgegevens = handlequery("SELECT rubrieknaam from Rubriek WHERE rubrieknummer = :rubriek ",$rubriekparameters);
	if($rubriekgegevens){
	
	$titel = $rubrieknaam = $rubriekgegevens[0][0];
	$key = array_search(''.$rubrieknaam.'', array_column($rubrieken, 'rubrieknaam'));
	$rubriekBreadcrumb = getRubriekPath($rubrieken,$key);
	
	
	}
	else{
	redirectJS("overview.php");
	}
	}else{
	redirectJS("overview.php");}
	
	$zoekfilter = '';
	
	}
	
	/* Wanneer er word gezocht op woord */
	else if(isset($_GET['search'])){ 
	$zoekfilter = $_GET['search'];
	
	//$parameters = array(":search" => "%" . $zoekfilter . "%");
	$keywords = explode(' ' ,$zoekfilter);
	$parameters = array();
	$last = count($keywords) - 1;
	$searchstring = '';
	
	foreach($keywords as $keyword => $value){
		$parameters[":$value"] = "%$value%";
		$searchstring .= " LIKE :$value ";
		 if($keyword != $last)
		 {
			$searchstring .= 'AND currentAuction.titel';
		 }
	}
		
		$titel = "Zoekresultaten";
		//$parameters = array(":search" => "%" . $zoekfilter . "%");
		$query = "SELECT TOP 9 * FROM currentAuction WHERE currentAuction.titel ".$searchstring." AND ".$pricecheck;
	
	}
	
	/* Wanneer er geen enkel filter gebruikt word */
	else{
	$titel = $zoekfilter = "Alle veilingen";
	$parameters = false;
	$query = "SELECT TOP 9 * from currentAuction WHERE ".$pricecheck;
	}
	
	/* Afvangen afstand */
	if(isset($_GET['dis'])){ 
	$products  = handlequery($query,$parameters);
	
	if(isset($_SESSION['gebruikersnaam'])){
	$userParameters = array(':gebruikersnaam' => $_SESSION['gebruikersnaam']);
	$userResults = handlequery("SELECT Gebruiker.plaatsnaam FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam",$userParameters);
	$userLocation = $userResults[0]['plaatsnaam'];
	$query = array();
	
		foreach($products as $product){
		
		$distanceinfo = (getDistanceData($userLocation,$product['plaats']));
			if($distanceinfo['distance'] <= $_GET['dis'] ){
			array_push ($query,$product);
			}
		}
		
	}
	}
?>