<?php 
require_once './header.php'; 
if (isset($_SESSION['gebruikersnaam'])){
	$htmlVeranderVoorwerp = '<form class="form-group" method="GET" action=""> 
	<input type="text" name="voorwerp" placeholder="Geef: voorwerpnummer, verkoper, plaats, titel, startprijs, rubriek" min="0"> <br>
	<input class="cta-orange" name="search-article" type="submit" value="Zoeken">
	</form>';
	if(isset($errorMessageArticle)) { 
		$htmlVeranderVoorwerp .= '<p class="error error-warning">'.$errorMessageArticle.'</p>'; 
	} else if (isset($_GET['search-article'])){
		$voorwerpNummer = $_GET['voorwerp'];
		if(is_numeric($voorwerpNummer)){
			$parametersVoorwerp = array(':voorwerpnummer' => (int)$voorwerpNummer,
				':titel' => null,
				':prijs' => (float)$voorwerpNummer,
				':verkoper' => null,
				':plaats' => null,
				':categorie' => null);
		} else {
			$parametersVoorwerp = array(':voorwerpnummer' => '-99999',
				':titel' => "%".$voorwerpNummer."%",
				':prijs' => '-10.00',
				':verkoper' => "%".$voorwerpNummer."%",
				':plaats' => "%".$voorwerpNummer."%",
				':categorie' => "%".$voorwerpNummer."%");
		}
		$queryGetSearchResults = sortProducts();
		$voorwerpen = handlequery($queryGetSearchResults, $parametersVoorwerp);	
		$artikelResultaten = '<div class="row">
		<div class="sidebar col-lg-3 col-sm-12">
		<p><b>Filter op de looptijd</b></p>
		<form method="get">
		<input name="voorwerp" type="hidden" value="'.$_GET['voorwerp'].'">
		<input name="search-article" type="hidden" value="'.$_GET['search-article'].'">										
		<button class="btn btn-primary" value="filter-desc" name="filter-time-desc">Filter producten aflopend</button>
		<button class="btn btn-secondary" value="filter-asc" name="filter-time-asc">Filter producten oplopend</button>
		</form>
		</div>
		<div class="col-lg-9 col-sm-12">
		<table class="table table-responsive search-results">
		<tr>
		<th scope="col"></th>
		<th scope="col">Product</th>
		<th scope="col">Titel</th>
		<th scope="col">Startprijs</th>
		<th scope="col">Plaats</th>
		<th scope="col">Gebruiker</th>
		<th scope="col">Looptijd</th>
		</tr>';
		foreach($voorwerpen as $voorwerp){
			$artikelResultaten .= "<tr>
			<td>
			<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>
			<img src=".returnSRCProduct($voorwerp['voorwerpnummer'])." class=preview-article />
			</a>
			</td>
			<td>
			<p><a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['voorwerpnummer'] ."</a></p>
			</td>
			<td>
			<p><a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['titel'] ."</a></p>
			</td>
			<td>
			<p><a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>€" . $voorwerp['startprijs'] ."</a></p>
			</td>
			<td>
			<p><a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['plaatsnaam'] ."</a></p>
			</td>
			<td>
			<p><a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['verkoper'] ."</a></p>
			</td>
			<td>
			<p><a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['loopTijd'] ."</a></p>
			</td>
			</tr>"; 
		} 
		$artikelResultaten .= '</tr></table></div></div>';
	} else if (isset($_GET['voorwerpInfo'])){
		$htmlVeranderVoorwerp = '
		<div class="col-lg-3 float-left"> 
		<div class="list-group" id="list-tab" role="tablist">
		<a class="list-group-item list-group-item-action active" id="list-product-list" data-toggle="list" href="#productinfo" role="tab" aria-controls="productinfo">Productinformatie</a>
		<a class="list-group-item list-group-item-action" id="list-change-bid" data-toggle="list" href="#bids" role="tab" aria-controls="list-change-bid">Biedingen</a>
		</div>
		<form method="get" class="btn-delete-product"><input type="hidden" name="product" value="'. $_GET['voorwerpInfo'] .'"><button type="submit" class="btn btn-danger" value="delete-product" name="delete-product">Verwijder veiling</button>';

		$htmlVeranderVoorwerp .= buttonsArticle($_GET);

		$htmlVeranderVoorwerp .= '</form>
		<div class="preview-img">
		<img src="'.returnSRCProduct($_GET['voorwerpInfo']).'" />
		</div>
		</div>';

		$artikelResultaten = ' ';	
	} else if (isset($_GET['biedings_nummer'])){
		$artikelResultaten = ' ';
		$htmlVeranderVoorwerp = '';
	} else if (isset($_GET['delete-product'])){
		deleteArticle($_GET['product']);
	} else if (isset($_GET['submit-product'])){
		updateProductInfo($_GET);
	} else if (isset($_GET['filter-time-desc'])){
		sortProductsDESC();
	} else if (isset($_GET['filter-time-asc'])){
		sortProductsASC();
	} else if (isset($_GET['block-auction'])){
		statusAuction($_GET, false);
	} else if (isset($_GET['activate-auction'])){
		statusAuction($_GET, true);
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
							<div class="clearfix"></div>
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
} else {
	redirectJS("./404.php");
}
require_once './footer.php';