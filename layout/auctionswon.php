<?php
$gebruiker = $_SESSION['gebruikersnaam'];

$query = "SELECT *
FROM currentAuction
INNER JOIN voorwerp ON currentAuction.voorwerpnummer = voorwerp.voorwerpnummer
WHERE voorwerp.koper = 'gebruiker'"
?>

<div class="tab-pane fade col-lg-9 float-left" id="content-auctions-won" role="tabpanel" aria-labelledby="list-profile-list">
	<div class="tab-pane fade show active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center"><h3>Gewonnen veilingen</h3></div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-margin float-left" style=" display: flex; flex-wrap: wrap;">
        <?= showProducts(false,$query,false); ?>
        </div>
	</div>
</div>