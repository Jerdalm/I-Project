<?php 
require_once './header.php'; 
if (isset($_SESSION['gebruikersnaam']) && $_SESSION['gebruikersnaam'] == 'admin'){
	$htmlGebruiker = '<form class="form-group" method="GET" action=""> 
	<input type="text" name="gebruiker" placeholder="Geef: Gebruikersnaam, E-mailadres, Plaats" min="0"> <br>
	<button class="btn cta-orange" name="search-user" type="submit" value="zoeken">Zoeken</button>
	</form>';
	if(isset($errorMessageUser)) { 
		$htmlGebruiker .= '<p class="error error-warning">'.$errorMessageUser.'</p>'; 
	} else if (isset($_GET['search-user'])){
		$gebruikersnaam = $_GET['gebruiker'];
		$parametersGebruiker = array(':gebruiker' => "%". $gebruikersnaam ."%",
			':mail' => "%". $gebruikersnaam ."%",
			':plaats' => "%". $gebruikersnaam ."%");
		$gebruikers = handlequery("SELECT * 
			FROM Gebruiker 
			WHERE gebruikersnaam like :gebruiker
			OR mailadres like :mail
			OR plaatsnaam like :plaats",$parametersGebruiker);
		$gebruikerResultaten = '<div class="row">
		<div class="col-lg-9 col-sm-12">
		<table class="table table-responsive search-results">
		<tr>
		<th scope="col">Gebruikersnaam</th>
		<th scope="col">E-mailadres</th>
		<th scope="col">Woonplaats</th>
		</tr>';
		foreach($gebruikers as $gebruiker){
			$gebruikerResultaten .= "<tr>
			<td>
			<a href='?gebruikersnaam=" . $gebruiker['gebruikersnaam'] . "'>" . $gebruiker['gebruikersnaam'] ."
			</a>
			</td>
			<td>
			<a href='?gebruikersnaam=" . $gebruiker['gebruikersnaam'] . "'>" . $gebruiker['mailadres'] ."
			</a>
			</td>
			<td>
			<a href='?gebruikersnaam=" . $gebruiker['gebruikersnaam'] . "'>" . $gebruiker['plaatsnaam'] ."
			</a>
			</td>
			</tr>";
		} 
		$gebruikerResultaten .= '</tr></table></div></div>';
	} else if (isset($_GET['gebruikersnaam'])){
		$htmlGebruiker = '
		<div class="col-lg-3 float-left"> 
		<div class="list-group" id="list-tab" role="tablist">
		<a class="list-group-item list-group-item-action active" id="list-product-list" data-toggle="list" href="#gebruikers" role="tab" aria-controls="userinfo">Geburikersinformatie</a>
		<a class="list-group-item list-group-item-action" id="list-change-bid" data-toggle="list" href="#bids" role="tab" aria-controls="list-change-bid">Biedingen</a>
		</div>
		<form method="get" class="btn-delete-product">
			<input type="hidden" name="gebruikersnaam" value="'. $_GET['gebruikersnaam'] .'">
			<button type="submit" class="btn btn-danger" value="block-user" name="block-user">Blokkeer gebruiker</button>
		</form>
		</div>';

		$gebruikerResultaten = ' ';
	}
	?>

	<main class="beheerdersomgeving">
		<section>
			<div class="container">
				<div class="gebruiker">
					<div class="row">
						<div class="col-lg-12">
							<?=$htmlGebruiker?> 
							<div class="tab-content" id="nav-tabContent">
								<?php
								require 'layout/gebruikers.php';
								require 'layout/biedingen.php'; 
								?>
							</div>
							<div class="clearfix"></div>
							<?php if(isset($gebruikerResultaten)) { 
								echo $gebruikerResultaten; 
							}?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>


	<?php  
if(isset($_GET['block-user'])) {
	blockUser($_GET['gebruikersnaam']);
	redirectJS("./change-user.php?gebruikersnaam=".$_GET['gebruikersnaam']);
}

} else {
	redirectJS("./404.php");
}
require_once './footer.php';