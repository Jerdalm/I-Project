<?php 
require_once './header.php'; 
$htmlVeranderVoorwerp = ' ';
$htmlVeranderBieding = ' ';
if (isset($_GET['search-article'])){
	$voorwerpNummer = $_GET['voorwerp'];
	$parametersVoorwerp = array(':voorwerpnummer' => "%".$voorwerpNummer."%",
		':titel' => "%".$voorwerpNummer."%",
		':prijs' => "%".$voorwerpNummer."%",
		':verkoper' => "%".$voorwerpNummer."%",
		':plaats' => "%".$voorwerpNummer."%",
		':categorie' => "%".$voorwerpNummer."%");
	$voorwerpen = handlequery("SELECT V.voorwerpnummer, V.verkoper, V.plaatsnaam, V.titel, V.startprijs, R.rubriekOpLaagsteNiveau 
		FROM VoorwerpInRubriek R right outer join Voorwerp V 								        
		on V.voorwerpnummer = R.voorwerpnummer
		left outer join Rubriek Ru
		on R.rubriekOpLaagsteNiveau = Ru.rubrieknummer
		WHERE v.voorwerpnummer like :voorwerpnummer
		or V.verkoper like :verkoper
		or V.plaatsnaam like :plaats
		or V.titel like :titel
		or v.startprijs like :prijs
		or Ru.rubrieknaam like :categorie
		order by v.voorwerpnummer asc",
		$parametersVoorwerp);		
	$artikelResultaten = '<table class="table"><tr><th scope="col">Resultaat</th></tr><tr>';
	foreach($voorwerpen as $voorwerp){
		$artikelResultaten .= "<tr>
		<td>
		<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['titel'] ."</a>
		</td>
		<td>
		<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['verkoper'] ."</a>
		</td>
		<td>
		<a href='?&voorwerpInfo=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['voorwerpnummer'] ."</a>
		</td>
		</tr>"; 
	} 
	$artikelResultaten .= '</tr></table>';
}

if(isset($_GET['voorwerpInfo'])){
	$artikelResultaten = ' ';
	
	$parametersbieding = array(':voorwerpnummer' => (int)$_GET['voorwerpInfo']);
	$biedingen = handlequery("SELECT * FROM Bod WHERE voorwerpNummer = :voorwerpnummer ORDER BY bodbedrag desc ", $parametersbieding);

	$voorwerpDetailParam = array(':voorwerpnummer' => $_GET['voorwerpInfo']);
	//Titel startprijs plaatsnaam einde looptijd misschien nog een eerste regel van de beschrijving
	$voorwerpDetailQuery = "SELECT titel, beschrijving, startprijs, plaatsnaam, looptijdEindeDag, CONVERT(TIME(0), [looptijdEindeTijdstip]) as looptijdEindeTijdstip
		FROM Voorwerp 
		WHERE voorwerpnummer = :voorwerpnummer";
	$query = FetchAssocSelectData($voorwerpDetailQuery, $voorwerpDetailParam);

	$htmlVeranderVoorwerp = '<div class="row">';
	$htmlVeranderVoorwerp .= '<div class="col-lg-8 col-sm-12">
	<h2>Productinformatie</h2>';
	$htmlVeranderVoorwerp .= '<form class="form-group change-form" method="GET" action="">'; 
	foreach ($query as $key => $value) {
		$htmlVeranderVoorwerp .= '<div class="form-group">';		
		$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
		switch ($key) {
			default:
			$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
			break;
		}
		$htmlVeranderVoorwerp .= '</div>';
	}
	$htmlVeranderVoorwerp .= '<button class="btn btn-success" name="change-article">Wijzig gegevens</button>';
	$htmlVeranderVoorwerp .= '</form></div>';


	$htmlVeranderVoorwerp .= '<div class="col-lg-4 col-sm-12">	
	<h2>Biedingen</h2>';	
	
	$htmlVeranderVoorwerp .= '<table class="table"><tr></tr>';
	foreach($biedingen as $bieding){

		$htmlVeranderVoorwerp .= "<tr>
		<td>
		<p><a href=?biedingsNummer=".$bieding['voorwerpnummer']."&biedingsBedrag=".$bieding['bodbedrag'].">€".$bieding['bodbedrag']."</a></p>
		</td>
		<td>
		<p><a href=?biedingsNummer=".$bieding['voorwerpnummer']."&biedingsBedrag=".$bieding['bodbedrag'].">".$bieding['gebruikersnaam']."</a></p>
		</td>
		<td>
		<p><a href=?biedingsNummer=".$bieding['voorwerpnummer']."&biedingsBedrag=".$bieding['bodbedrag'].">".date_format(date_create($bieding['bodDag']), "d-m-Y")."</a></p>
		</td>
		</tr>";
	} 
	$htmlVeranderVoorwerp .= '</table>';

	$htmlVeranderVoorwerp .= '</div>';

	$htmlVeranderVoorwerp .= '</div>';
}

?>

<main class="beheerdersomgeving">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="artikelnummer">
						<!-- form om te zoeken op artikelnummer -->
						<form class="form-group" method="GET" action=""> 
							<input type="text" name="voorwerp" placeholder="Voorwerp" min="0"> <br>
							<input class="cta-orange" name="search-article" type="submit" value="Zoeken">
						</form>
						<?php if(isset($errorMessageArticle)) { 
							echo '<p class="error error-warning">'.$errorMessageArticle.'</p>'; 
						}
						echo $htmlVeranderVoorwerp;
						?>
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
require_once './footer.php'; ?>