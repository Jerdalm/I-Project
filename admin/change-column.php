<?php 
require_once './header.php';
if (isset($_SESSION['gebruikersnaam'])){
	$queryGetColumns = handlequery("SELECT * FROM rubriek ORDER BY rubrieknaam asc");

	$htmlRubriek = '<div class="col-lg-6"><form class="form-group" method="GET" action=""><div class="form-group"> 
	<input type="text" class="form-control" name="rubrieken" placeholder="Geef: Rubriek of rubrieknummer"> <br>
	<button class="btn cta-orange" class="form-control" name="search-column" type="submit" value="zoeken">Zoeken</button></div>
	</form>
	</div>
	<div class="col-lg-6">
	<form method="get" class="form-group">
	<input name="column-name" class="form-control" placeholder="Voeg rubriek toe"><br>
	<select name="column-head" class="form-control">
	<option value="" disabled selected>Kies een hoofdsubriek...</option>';
	foreach ($queryGetColumns as $option => $value) {
		$htmlRubriek .= '<option value="'.$value['rubrieknummer'].'">'.$value['rubrieknaam'].'</option>';
	}
	$htmlRubriek .= '</select><br>
	<button class="btn btn-primary" name="upload-column" value="upload-column">Maak nieuw rubriek aan</button>
	</form>
	</div>';
	if(isset($errorMessageColumn)) { 
		$htmlRubriek .= '<p class="error error-warning">'.$errorMessageColumn.'</p>'; 
	} else if (isset($_GET['search-column'])){
		if(isset($_GET['rubrieken'])) {
			$rubriek = $_GET['rubrieken'];
			if(is_numeric($rubriek)) {
				$parametersRubriek = array(':rubriek' => null,
					':nummer' => (int)$rubriek);
			} else {
				$parametersRubriek = array(':rubriek' => "%".$rubriek."%",
					':nummer' => '-1111');
			}
		}
		$rubrieken = handlequery("SELECT r.rubrieknummer, r.rubrieknaam, r2.rubrieknaam as hoofdrubriek FROM rubriek r LEFT JOIN rubriek r2 on r2.rubrieknummer = r.hoofdrubriek 
			WHERE r.rubrieknaam LIKE :rubriek
			OR r.rubrieknummer = :nummer	
			GROUP BY r.rubrieknummer, r.rubrieknaam, r2.rubrieknaam
			ORDER BY r.rubrieknummer ASC
			",$parametersRubriek);
		$rubriekResultaten = '<div class="col-lg-9 col-sm-12">
		<table class="table table-responsive search-results">
		<tr>
		<th scope="col">Rubrieknummer</th>
		<th scope="col">Rubriek</th>
		<th scope="col">Hoofdrubriek</th>
		</tr>';
		foreach($rubrieken as $rubriek){
			$rubriekResultaten .= "<tr>
			<td>
			<a href='?rubriek=" . $rubriek['rubrieknummer'] . "'>" . $rubriek['rubrieknummer'] ."
			</a>
			</td>
			<td>
			<a href='?rubriek=" . $rubriek['rubrieknummer'] . "'>" . $rubriek['rubrieknaam'] ."
			</a>
			</td>
			<td>
			<a href='?rubriek=" . $rubriek['hoofdrubriek'] . "'>" . $rubriek['hoofdrubriek'] ."
			</a>
			</td>
			</tr>";
		} 
		$rubriekResultaten .= '</table></div>';
	} else if (isset($_GET['rubriek'])){
		$htmlRubriek = '
		<div class="col-lg-3 float-left"> 
		<div class="list-group" id="list-tab" role="tablist">
		<a class="list-group-item list-group-item-action active" id="list-product-list" data-toggle="list" href="#rubriekinfo" role="tab" aria-controls="list-columninfo">Rubriekinformatie</a>
		<a class="list-group-item list-group-item-action" id="list-change-bid" data-toggle="list" href="#subrubrieken" role="tab" aria-controls="list-subcolumns">Subrubrieken</a>
		</div>
		<form method="get" class="btn-delete-product"><input type="hidden" name="product" value="'. $_GET['rubriek'] .'"><button type="submit" class="btn btn-danger" value="delete-product" name="delete-column">Verwijder rubriek</button></form>';
		$htmlRubriek .= toonStatus($_GET['rubriek']);
		$htmlRubriek .= '</div>';

		$rubriekResultaten = ' ';
	} else if (isset($_GET['delete-column'])){
		deleteColumn($_GET['rubriek']);
	} else if (isset($_GET['upload-column'])){
		uploadColumn($_GET);	
	}
	?>

	<main class="beheerdersomgeving">
		<section>
			<div class="container">
				<div class="rubriek">
					<div class="row">
						<?=$htmlRubriek?> 
						<div class="tab-content col-lg-9 col-sm-12" id="nav-tabContent">
							<?php
							require 'layout/rubriek.php';
							require 'layout/subrubrieken.php'; 
							?>
						</div>
						<div class="clearfix"></div>
						<?php if(isset($rubriekResultaten)) { 
							echo $rubriekResultaten; 
						}?>
					</div>
				</div>
			</div>
		</section>
	</main>


	<?php  
} else {
	// redirectJS("./404.php");
}
require_once './footer.php';
