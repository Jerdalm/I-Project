<?php
if (isset($_GET['voorwerpInfo'])) {
	$htmlToonProductInfo = ' ';
	$voorwerpDetailParam = array(':voorwerpnummer' => $_GET['voorwerpInfo']);
	$voorwerpDetailQuery = "SELECT titel AS Titel, beschrijving AS Beschrijving, startprijs AS Startprijs, plaatsnaam AS Plaatsnaam, looptijdEindeDag AS 'Laatste dag', CONVERT(TIME(0), [looptijdEindeTijdstip]) as 'Einde Tijdstip' FROM Voorwerp WHERE voorwerpnummer = :voorwerpnummer";
	$query = FetchAssocSelectData($voorwerpDetailQuery, $voorwerpDetailParam);

	foreach ($query as $key => $value) {
		$htmlToonProductInfo .= '<div class="form-group">';		
		$htmlToonProductInfo .= '<label>'. $key . '</label>';
		switch ($key) {
			default:
			$htmlToonProductInfo .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
			break;
		}
		$htmlToonProductInfo .= '</div>';
	}

	$voorwerpDetailParam = array(':voorwerpnummer' => $_GET['voorwerpInfo']);
	$artikelResultaten = ' ';
	$voorwerpDetailQuery = "SELECT voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, looptijdbeginDag, CONVERT(TIME(0), [looptijdbeginTijdstip]) as looptijdbeginTijdstip, verzendkosten, verzendinstructies 
	FROM Voorwerp 
	WHERE voorwerpnummer = :voorwerpnummer";
	$queryVoorwerpDetail = FetchAssocSelectData($voorwerpDetailQuery, $voorwerpDetailParam);
	if (isset($_GET['submit-product'])) {
		echo "aanwezig";
		die();
		updateProductInfo($_GET);
	}
	?>

	<div class="tab-pane fade col-lg-9 col-sm-12 float-left" id="productinfo" role="tabpanel" aria-labelledby="list-profile-list">
		<div class="tab-pane fade show active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
			<h2>Productinformatie</h2>
			<form class="form-group change-form" method="GET" action="">
				<?php if(isset($htmlToonProductInfo)){ echo $htmlToonProductInfo;}?>
				<button type="button" class="btn btn btn-success" data-toggle="modal" data-target="#changeInfo">Bewerk gegevens</button>
				<?php require 'layout/changeProductInfoModal.php';?>
			</form>
		</div>
	</div>
	<?php } ?>