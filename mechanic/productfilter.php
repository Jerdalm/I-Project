<?php 
	
	$pagination_available = isset($_GET['pagination']) && !is_null($_GET['pagination']);
	$perpage_available = isset($_GET['perpage']) && !empty($_GET['perpage']);
	
	if($pagination_available && $perpage_available){
		if(is_numeric($_GET['pagination']) && is_numeric($_GET['perpage'])){
			$start   = $_GET['pagination'];	
			$perpage = $_GET['perpage'];
		}
		else{
		$start = 0;
		$perpage = 9;
		}
	}
	else{ 
	$start = 0;
	$perpage = 9;
	}
	
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
	
	$productcount = handlequery("SELECT COUNT(*) as productaantal from currentAuction 
	INNER JOIN VoorwerpinRubriek
	ON VoorwerpinRubriek.voorwerpnummer = currentAuction.voorwerpnummer
	Where rubriekOpLaagsteNiveau IN ".$rubriekdata. " AND ".$pricecheck."");
	
	$pagRows = $productcount[0]['productaantal'];
	
	$query = "SELECT * from currentAuction 
	INNER JOIN VoorwerpinRubriek
	ON VoorwerpinRubriek.voorwerpnummer = currentAuction.voorwerpnummer
	Where rubriekOpLaagsteNiveau IN ".$rubriekdata. " AND ".$pricecheck."
	ORDER by currentAuction.voorwerpnummer OFFSET ".$start." ROWS FETCH NEXT ".$perpage." ROWS ONLY
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
		$productcount = handlequery("SELECT COUNT(*) as productaantal FROM currentAuction WHERE currentAuction.titel ".$searchstring." AND ".$pricecheck."",$parameters);
		$pagRows = $productcount[0]['productaantal'];
		$query = "SELECT * FROM currentAuction WHERE currentAuction.titel ".$searchstring." AND ".$pricecheck."
		ORDER by voorwerpnummer OFFSET ".$start." ROWS FETCH NEXT ".$perpage." ROWS ONLY";
	
	}
	
	/* Wanneer er geen enkel filter gebruikt word */
	else{
	$titel = $zoekfilter = "Alle veilingen";
	$parameters = false;
	$productcount = handlequery("SELECT COUNT (*) as productaantal from currentAuction WHERE ".$pricecheck);
	$pagRows = $productcount[0]['productaantal'];
	$query = "SELECT * from currentAuction WHERE ".$pricecheck." ORDER by voorwerpnummer OFFSET ".$start." ROWS FETCH NEXT ".$perpage." ROWS ONLY";
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