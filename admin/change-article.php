<?php 
require_once './header.php'; 
$htmlVeranderVoorwerp = '<form class="form-group" method="GET" action=""> 
<input type="text" name="voorwerp" placeholder="Voorwerp" min="0"> <br>
<input class="cta-orange" name="search-article" type="submit" value="Zoeken">
</form>';
if(isset($errorMessageArticle)) { 
	$htmlVeranderVoorwerp .= '<p class="error error-warning">'.$errorMessageArticle.'</p>'; 
} else if (isset($_GET['search-article'])){
	$voorwerpNummer = $_GET['voorwerp'];
	$parametersVoorwerp = array(':voorwerpnummer' => "%".$voorwerpNummer."%",
		':titel' => "%".$voorwerpNummer."%",
		':prijs' => "%".$voorwerpNummer."%",
		':verkoper' => "%".$voorwerpNummer."%",
		':plaats' => "%".$voorwerpNummer."%",
		':categorie' => "%".$voorwerpNummer."%");
	$voorwerpen = handlequery("SELECT V.voorwerpnummer, V.verkoper, V.plaatsnaam, V.titel, V.startprijs, R.rubriekOpLaagsteNiveau 
		FROM VoorwerpInRubriek R right outer join Voorwerp V 								        
		on V.voorwerpnummer = R.voorwerpnummer
		left outer join Rubriek Ru
		on R.rubriekOpLaagsteNiveau = Ru.rubrieknummer
		WHERE v.voorwerpnummer like :voorwerpnummer
		or V.verkoper like :verkoper
		or V.plaatsnaam like :plaats
		or V.titel like :titel
		or v.startprijs like :prijs
		or Ru.rubrieknaam like :categorie
		order by v.voorwerpnummer asc",
		$parametersVoorwerp);		
	$artikelResultaten = '<table class="table"><tr><th scope="col">Titel</th><th scope="col">Gebruiker</th><th scope="col">Voorwerpnummer</th></tr><tr>';
	foreach($voorwerpen as $voorwerp){
		$artikelResultaten .= "<tr>
		<td>
		<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['titel'] ."</a>
		</td>
		<td>
		<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['verkoper'] ."</a>
		</td>
		<td>
		<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['voorwerpnummer'] ."</a>
		</td>
		</tr>"; 
	} 
	$artikelResultaten .= '</tr></table>';
} else if(isset($_GET['voorwerpInfo'])){
	$htmlVeranderVoorwerp = '
	<div class="col-lg-3 sidebar float-left"> 
	<div class="list-group" role="tablist">
	<a class="list-group-item list-group-item-action active" id="list-product-details" data-toggle="list" href="#productinfo" role="tab" aria-controls="list-product-details">Productinformatie</a>
	<a class="list-group-item list-group-item-action" id="list-change-bid" data-toggle="list" href="#bids" role="tab" aria-controls="list-change-bid">Biedingen</a>
	</div>
	<form method="get" class="btn-delete-product"><button type="button" class="btn btn-danger" name="delete-product">Verwijder artikel</button></form>
	</div>';

	$artikelResultaten = ' ';	
} else if(isset($_GET['biedings_nummer'])){
	$artikelResultaten = ' ';
	$htmlVeranderVoorwerp = '';
}
?>

<main class="beheerdersomgeving">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="artikelnummer">
						<?=$htmlVeranderVoorwerp?> 
						<div class="tab-content" id="nav-tabContent">
							<?php
							require 'layout/biedingen.php'; 
							require 'layout/productinfo.php';
							?>
						</div>
					</div>
					<?php if(isset($artikelResultaten)) { 
						echo $artikelResultaten; 
					}?>
				</div>
			</div>
		</div>
	</section>
</main>


<?php  
require_once './footer.php'; ?>