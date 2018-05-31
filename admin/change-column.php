<?php 
require_once './header.php'; 
$htmlRubriek = '<form class="form-group" method="GET" action=""> 
<input type="text" name="rubriek" placeholder="Geef: Rubriek of rubrieknummer"> <br>
<button class="btn cta-orange" name="search-column" type="submit" value="zoeken">Zoeken</button>
</form>
<div class="row">
	<div class="col-lg-3">
		<form method="get">
		<div class="form-group">
			<label>Rubriek toevoegen</label>
			<input name="column-name">
			<button class="btn btn-primary" name="upload-column" value="upload-column">Maak nieuw rubriek aan</button>
		</form>
	</div>
</div>
</div>';
if(isset($errorMessageColumn)) { 
	$htmlRubriek .= '<p class="error error-warning">'.$errorMessageColumn.'</p>'; 
} else if (isset($_GET['search-column'])){
	$rubriek = $_GET['rubriek'];
	$parametersRubriek = array(':rubriek' => "%". $rubriek ."%",
							   ':nummer' => (int)$rubriek);
	$rubrieken = handlequery("SELECT * 
		FROM Rubriek 
		WHERE rubrieknaam like :rubriek
		OR rubrieknummer = :nummer	
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
	<form method="get" class="btn-delete-product"><input type="hidden" name="product" value="'. $_GET['rubriek'] .'"><button type="submit" class="btn btn-danger" value="delete-product" name="delete-column">Verwijder rubriek</button></form>
	</div>';

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
			<div class="gebruiker">
				<div class="row">
					<div class="col-lg-12">
						<?=$htmlRubriek?> 
						<div class="tab-content" id="nav-tabContent">
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
		</div>
	</section>
</main>


<?php  
require_once './footer.php'; ?>