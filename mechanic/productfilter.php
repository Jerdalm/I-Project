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
	
	
	$parameters = false;
	
	$query = "SELECT * from currentAuction 
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
	header("Location:overview.php");
	}
	}else{
	header("Location:overview.php");}
	
	$zoekfilter = '';
	
	}
	
	/* Wanneer er word gezocht op woord */
	else if(isset($_GET['search'])){ 
	$zoekfilter = $_GET['search'];
	
		$titel = "Zoekresultaten";
		$parameters = array(":search" => "%" . $zoekfilter . "%");
		$query = "SELECT * FROM currentAuction WHERE currentAuction.titel LIKE :search AND ".$pricecheck;
	
	}
	
	/* Wanneer er geen enkel filter gebruikt word */
	else{
	$titel = $zoekfilter = "Alle veilingen";
	$parameters = false;
	$query = "SELECT * from currentAuction WHERE ".$pricecheck;
	}
	
	/* Afvangen afstand */
	if(isset($_GET['dis'])){ 
	handlequery($query,$parameters);
	
	
	}
?>