<?php
require_once './header.php'; 

$queryNumberUser = FetchAssocSelectData("SELECT COUNT(gebruikersnaam) AS aantal FROM Gebruiker");
$queryNumberSellers = FetchAssocSelectData("SELECT COUNT(gebruikersnaam) AS aantal FROM Gebruiker WHERE soortGebruiker = 2");
$queryNumberAdmin = FetchAssocSelectData("SELECT COUNT(gebruikersnaam) AS aantal FROM Gebruiker WHERE soortGebruiker = 3");
print_r($queryNumberAdmin);
?>

<main>
	<div class="container">
		<section>
			<div class="row">
				<div class="col-lg-3 col-sm-12 float-left sidebar"> 
					<div class="list-group" id="list-tab" role="tablist">
						<a class="list-group-item list-group-item-action" href="./change-auction.php">Veiling</a>
						<a class="list-group-item list-group-item-action" href="./change-user.php">Gebruiker</a>
						<a class="list-group-item list-group-item-action" href="./change-column.php">Rubriek</a>
					</div>
				</div>
				<div class="col-lg-9 col-sm-12">
					<h2>Aantal gebruikers: <?= $queryNumberUser['aantal']?></h2>
					<h2>Aantal verkopers: <?= $queryNumberSellers['aantal']?></h2>					
				</div>
			</div>
			<div class="row">
				<
			</div>
		</section>
	</div>
</main>


<?php
require_once './footer.php'; 
?>
