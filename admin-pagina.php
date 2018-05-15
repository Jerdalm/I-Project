<?php 
require_once 'header.php'; 

if($_SESSION['gebruikersnaam'] == "admin") { 

	if (isset($_GET['zoekenVoorwerp'])){

		$voorwerpNummer = $_GET['voorwerp'];
		$parametersVoorwerp = array(':voorwerpnummer' => $voorwerpNummer);
		$voorwerpen = handlequery("SELECT * FROM Voorwerp WHERE voorwerpnummer = :voorwerpnummer",$parametersVoorwerp);
		echo print_r($voorwerpen);
		$artikelResultaten = '<table class="table"><tr><th scope="col">Voorwerp</th></tr><tr>';
		foreach($voorwerpen as $voorwerp){

			$getpath = "$_SERVER[QUERY_STRING]";
			$artikelResultaten .= "<tr>" . "<td>" . "<a href='?".$getpath."&voorwerpForm=" . $voorwerp['titel'] . "'>" .  $voorwerp['titel'] ."</a>". "</td>" . "</tr>"; 


		} 
		$artikelResultaten .= '</tr></table>';
	} else if (isset($_GET['zoekenGebruiker'])) {
		$gebruikersnaam = $_GET['gebruiker'];
		$parametersGebruiker = array(':gebruiker' => "%". $gebruikersnaam ."%");
		$gebruikers = handlequery("SELECT * FROM Gebruiker WHERE gebruikersnaam like :gebruiker",$parametersGebruiker);
		echo print_r($gebruikers);
		$gebruikerResultaten = '<table class="table"><tr><th scope="col">Gebruikersnaam</th></tr><tr>';
		foreach($gebruikers as $gebruiker){
			$gebruikerResultaten .= "<tr>" . "<td>" . "<a href='?gebruikersnaamForm=" . $gebruiker['gebruikersnaam'] . "'>" .  $gebruiker['gebruikersnaam'] ."</a>". "</td>" . "</tr>";
		} 
		$gebruikerResultaten .= '</tr></table>';
	}

	?>

	<main>
		<div class="container">
			<div class="row">
				<div class="artikelnummer">
					<!-- form om te zoeken op artikelnummer -->
					<div class="col-lg-4">
						<form class="form-group" method="GET" action=""> 
							<input type="number" name="voorwerp" placeholder="Voorwerpnummer"> <br>
							<input class="cta-orange" name="zoekenVoorwerp" type="submit" value="Zoeken">
						</form>
					</div>
				</div>

				<div class="gebruiker">
					<!-- for om te zoeken op gebruiker -->
					<div class="col-lg-4">
						<form class="form-group" method="GET" action=""> 
							<input type="text" name="gebruiker" placeholder="Gebruikersnaam"> <br>
							<input class="cta-orange" name="zoekenGebruiker" type="submit" value="Zoeken">
						</form>
					</div>
				</div>
				<?php if(isset($artikelResultaten)) { 
					echo $artikelResultaten; 
				} else if(isset($gebruikerResultaten)) { 
					echo $gebruikerResultaten; 
				}?>
			</div>

		<?php }
		if (isset($_GET['voorwerpForm'])) {?>
			<!-- Voor nu op deze manier gedaan, kan met een foreach. Later nog naar kijken maar aangezien de tijdslimiet zo gedaan om geen tijd te verspillen. -->

			<form class="form-group" method="GET" action=""> 
				
				<?php 
				$kweerie = "SELECT * FROM Voorwerp WHERE voorwerpnummer = :voorwerpnummer";
				$query = FetchAssocSelectData($kweerie, $parametersVoorwerp);
				foreach ($query as $key => $value) {
					echo '<label>'. $key . '</label>';
					echo '<input type="text" name="'.$value.'" value="'.$value.'"><br>';
				}
			}
				echo '</form>';
				?>
			

		// nog niet helemaal werkend. dit is de query om de tabel te updaten.
		<?php
		if (isset($_GET['verzenden'])) {
			$parametersUpdate = array(
				':titel' => $_GET['titel'], 
				':beschrijving' => $_GET['beschrijving'],
				':startprijs' => $_GET['startprijs'],
				':betalingswijze' => $_GET['betalingswijze'],
				':betalingsinstructie' => $_GET['betalingsinstructie'],
				':plaatsnaam' => $_GET['plaatsnaam'],
				':land' => $_GET['land'],
				':looptijd' => $_GET['looptijd'],
				':looptijdbeginDag' => $_GET['looptijdbeginDag'],
				':looptijdbeginTijdstip' => $_GET['looptijdbeginTijdstip'],
				':verzendkosten' => $_GET['verzendkosten'],
				':verzendinstructies' => $_GET['verzendinstructies'],
				':verkoper' => $_GET['verkoper'],
				':koper' => $_GET['koper'],
				':looptijdeindeDag' => $_GET['looptijdeindeDag'],
				':looptijdeindeTijdstip' => $_GET['looptijdeindeTijdstip'],
				':veilingGesloten' => $_GET['veilingGesloten'],
				':verkoopPrijs' => $_GET['verkoopPrijs']);

			handlequery("UPDATE Voorwerp SET
				titel = :titel,
				beschrijving = :beschrijving,
				startprijs = CONVERT(NUMERIC(8,2), :startprijs),
				betalingswijze = CONVERT(INT, :betalingswijze),
				betalingsinstructie = :betalingsinstructie,
				plaatsnaam = :plaatsnaam,
				land = :land,
				looptijd = :looptijd,
				looptijdbeginDag = :looptijdbeginDag,
				looptijdbeginTijdstip = :looptijdbeginTijdstip,
				verzendkosten = CONVERT(NUMERIC(5,2), :verzendkosten),
				verzendinstructies = :verzendinstructies,
				verkoper = :verkoper,
				koper = :koper,
				looptijdeindeDag = :looptijdeindeDag,
				looptijdeindeTijdstip = :looptijdeindeTijdstip,
				veilingGesloten = :veilingGesloten,
				verkoopPrijs = CONVERT(NUMERIC(8,2), :verkoopPrijs)",
				$parametersUpdate);
			}?>
		</div>
	</main>
	
	<?php require_once './footer.php'; ?>

