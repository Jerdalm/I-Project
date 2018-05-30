<?php
if (isset($_GET['voorwerpInfo'])) {
	$htmlToonBiedingen = ' ';
	$parametersbieding = array(':voorwerpnummer' => (int)$_GET['voorwerpInfo']);
	$biedingen = handlequery("SELECT * FROM Bod WHERE voorwerpNummer = :voorwerpnummer ORDER BY bodbedrag desc ", $parametersbieding);
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
		<a type="button" href=&naam='.$bieding['gebruikersnaam'].'&bodBedrag='.$bieding['bodbedrag'].' class="btn btn btn-success btn-change-bid" data-toggle="modal" data-target="#changeBid" data-id="'.$bieding['bodbedrag'].'">Bewerk bod</a>
		</td>
		</tr>';
	}
}
if(isset($_GET['gebruikersnaam'])){
	$htmlToonBiedingen = ' ';
	$parametersbieding = array(':gebruikersnaam' => $_GET['gebruikersnaam']);
	$biedingen = handlequery("SELECT * FROM Bod WHERE gebruikersnaam = :gebruikersnaam ORDER BY bodbedrag desc ", $parametersbieding);
	$biedings = FetchAssocSelectData("SELECT voorwerpnummer, bodbedrag, bodDag AS Datum, CONVERT(TIME(0), [bodTijdstip]) AS Tijd FROM Bod WHERE gebruikersnaam = :gebruikersnaam", $parametersbieding);
	foreach($biedingen as $bieding){
		$htmlToonBiedingen .= '<tr>
		<td>
		<p>€'.$bieding['bodbedrag'].'</p>
		</td>
		<td>
		<p>'.date_format(date_create($bieding['bodDag']), "d-m-Y").'</p>
		</td>
		<td>
		<a type="button" href=&naam='.$bieding['gebruikersnaam'].'&bodBedrag='.$bieding['bodbedrag'].' class="btn btn btn-success btn-change-bid" data-toggle="modal" data-target="#changeBid" data-id="'.$bieding['bodbedrag'].'">Bewerk bod</a>
		</td>
		</tr>';
	}
} 
?>

<div class="tab-pane fade col-lg-9 col-sm-12 float-left" id="bids" role="tabpanel" aria-labelledby="list-change-bid">	
	<div class="tab-pane fade show active" id="bids" role="tabpanel" aria-labelledby="list-change-bid">
		<h2>Biedingen</h2>
		<table class="table striped">
			<tr>
				<th scope="col">Bedrag</th>
				<?php if (isset($_GET['voorwerpInfo'])){ echo '<th scope="col">Gebruiker</th>';}?>
				<th scope="col">Datum</th>
				<th scope="col"></th>
			</tr>
			<?php if(isset($htmlToonBiedingen)){ echo $htmlToonBiedingen;} ?>
			<?php require 'layout/changeBidModal.php';?>
		</table>
	</div>
</div>

<?php 
if (isset($_GET['submit-bit']) && isset($_GET['bodBedragOud'])) {
	updateBit($_GET);
}?>