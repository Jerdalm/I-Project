<?php
if (isset($_GET['voorwerpInfo'])) {
	$htmlToonBiedingen = ' ';
	$parametersbieding = array(':voorwerpnummer' => (int)$_GET['voorwerpInfo']);
	$biedingen = handlequery("SELECT * FROM Bod WHERE voorwerpNummer = :voorwerpnummer ORDER BY bodbedrag desc ", $parametersbieding);
	if (false) {
		$parametersbod = array(':voorwerpnummer' => $_GET['voorwerpInfo'],
			':bedrag' => $_GET['bodBedrag']);
	}
	$biedings = FetchAssocSelectData("SELECT voorwerpnummer, gebruikersnaam, bodbedrag, bodDag AS Datum, CONVERT(TIME(0), [bodTijdstip]) AS Tijd FROM Bod WHERE voorwerpNummer = :voorwerpnummer", $parametersbieding);
	foreach($biedingen as $bieding){
		$htmlToonBiedingen .= '<tr>
		<td>
		<p>€'.$bieding['bodbedrag'].'</p>
		</td>
		<td>
		<p>'.$bieding['gebruikersnaam'].'</p>
		</td>
		<td>
		<p>'.date_format(date_create($bieding['bodDag']), "d-m-Y").'</p>
		</td>
		<td>
		<button type="button" class="btn btn btn-success btn-change-bid" data-toggle="modal" data-target="#changeBid" data-id="'.$bieding['bodbedrag'].'">Bewerk bod</button>
		</td>
		</tr>';
	} 

	if (isset($_GET['submit-bit'])) {
		echo "aanwezig";
		die();
		updateBit($_GET);
	}
	?>

	<div class="tab-pane fade col-lg-9 col-sm-12 float-left" id="bids" role="tabpanel" aria-labelledby="list-profile-list">	
		<div class="tab-pane fade show active" id="content-user-details" role="tabpanel" aria-labelledby="list-user-details">
			<h2>Biedingen</h2>
			<table class="table striped">
				<tr>
					<th scope="col">Bedrag</th>
					<th scope="col">Gebruiker</th>
					<th scope="col">Datum</th>
					<th scope="col"></th>
				</tr>
				<?php if(isset($htmlToonBiedingen)){ echo $htmlToonBiedingen;} ?>
				<?php require 'layout/changeBidModal.php';?>
			</table>
		</div>
	</div>

	<?php } ?>