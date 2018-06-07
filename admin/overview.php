<?php
require_once './header.php'; 
if (isset($_SESSION['gebruikersnaam']) && $_SESSION['gebruikersnaam'] == 'admin'){
	$queryNumberUser = FetchAssocSelectData("SELECT COUNT(gebruikersnaam) AS aantal FROM Gebruiker");
	$queryNumberSellers = FetchAssocSelectData("SELECT COUNT(gebruikersnaam) AS aantal FROM Gebruiker WHERE soortGebruiker = 2");
	$queryNumberBlokked = FetchAssocSelectData("SELECT COUNT(gebruikersnaam) AS aantal FROM Gebruiker WHERE soortGebruiker = 3");
	$queryNumberAuctions = FetchAssocSelectData("SELECT COUNT(voorwerpnummer) AS aantal FROM voorwerp");
	$queryNumberAuctionsOpen = FetchAssocSelectData("SELECT COUNT(voorwerpnummer) AS aantal FROM voorwerp WHERE veilingGesloten = 0");
	// print_r($queryNumberAdmin);
	?>

	<main>
		<div class="container">
			<section>
				<div class="row">
					<div class="col-lg-3 col-sm-12 float-left"> 
						<div class="list-group" id="list-tab" role="tablist">
							<a class="list-group-item list-group-item-action icon-auction" href="./change-auction.php">Veiling</a>
							<a class="list-group-item list-group-item-action icon-user" href="./change-user.php">Gebruiker</a>
							<a class="list-group-item list-group-item-action icon-column" href="./change-column.php">Rubriek</a>
						</div>
					</div>
					<div class="col-lg-9 col-sm-12">
						<ul class="list-unstyled">
							<li class="media">
								<!-- <img class="mr-3" src="..." alt="Generic placeholder image"> -->
								<div class="media-body">
									<h5 class="mt-0 mb-1 font-italic">Aantal gebruikers: <?= $queryNumberUser['aantal']?></h5>
									<p>Het aantal gebruikers is de afgelopen dagen 100% gegroeid!</p>
								</div>
							</li>
							<li class="media my-4">
								<!-- <img class="mr-3" src="..." alt="Generic placeholder image"> -->
								<div class="media-body">
									<h5 class="mt-0 mb-1 font-italic">Aantal verkopers: <?= $queryNumberSellers['aantal']?></h5>
									Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
								</div>
							</li>
							<li class="media">
								<!-- <img class="mr-3" src="..." alt="Generic placeholder image"> -->
								<div class="media-body">
									<h5 class="mt-0 mb-1">Aantal geblokkeerde gebruikers: <?=$queryNumberBlokked['aantal']?></h5>
									Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
								</div>
							</li>
							<li class="media my-4">
								<!-- <img class="mr-3" src="..." alt="Generic placeholder image"> -->
								<div class="media-body">
									<h5 class="mt-0 mb-1">Aantal veilingen: <?=$queryNumberAuctions['aantal']?></h5>
									Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
								</div>
							</li>
							<li class="media">
								<!-- <img class="mr-3" src="..." alt="Generic placeholder image"> -->
								<div class="media-body">
									<h5 class="mt-0 mb-1">Aantal open veilingen: <?=$queryNumberAuctionsOpen['aantal']?></h5>
									Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
								</div>
							</li>

						</ul>	
					</div>
				</div>
				<div class="row">
					
				</div>
			</section>
		</div>
	</main>


	<?php
}
require_once './footer.php'; 
?>
