<?php 
require_once './header.php'; 

if($_SESSION['gebruikersnaam'] == "admin") { 
	$htmlVeranderVoorwerp = ' ';
	$htmlVeranderGebruiker= ' ';
	$_SESSION['voorwerpnummer'] = ' ';
	if (isset($_GET['zoekenVoorwerp'])){
		$voorwerpNummer = $_GET['voorwerp'];
		$parametersVoorwerp = array(':voorwerpnummer' => $voorwerpNummer);
		$voorwerpen = handlequery("SELECT * FROM Voorwerp WHERE voorwerpnummer = :voorwerpnummer",$parametersVoorwerp);		
		$artikelResultaten = '<table class="table"><tr><th scope="col">Voorwerp</th></tr><tr>';
		foreach($voorwerpen as $voorwerp){
			$getpath = "$_SERVER[QUERY_STRING]";
			$artikelResultaten .= "<tr>" . "<td>" . "<a href='?".$getpath."&voorwerpForm=" . $voorwerp['titel'] . "'>" . $voorwerp['titel'] ."</a>". "</td>"."</tr>"; 
		} 
		$artikelResultaten .= '</tr></table>';
	} else if (isset($_GET['zoekenGebruiker'])) {
		$gebruikersnaam = $_GET['gebruiker'];
		$parametersGebruiker = array(':gebruiker' => "%". $gebruikersnaam ."%");
		$gebruikers = handlequery("SELECT * FROM Gebruiker WHERE gebruikersnaam like :gebruiker",$parametersGebruiker);
		$gebruikerResultaten = '<table class="table"><tr><th scope="col">Gebruikersnaam</th></tr><tr>';
		foreach($gebruikers as $gebruiker){
			$gebruikerResultaten .= "<tr>" . "<td>" . "<a href='?gebruikersnaamForm=" . $gebruiker['gebruikersnaam'] . "'>" . $gebruiker['gebruikersnaam'] ."</a>". "</td>" . "</tr>";
		} 
		$gebruikerResultaten .= '</tr></table>';
	}

	if (isset($_GET['voorwerpForm'])) {
		$artikelResultaten = ' ';
		$htmlVeranderVoorwerp = '<form class="form-group" method="GET" action="">'; 

		$kweerie = "SELECT * FROM Voorwerp WHERE voorwerpnummer = :voorwerpnummer";
		$query = FetchAssocSelectData($kweerie, $parametersVoorwerp);
		foreach ($query as $key => $value) {
			if ($key == 'voorwerpnummer') {				
				$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
				$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				continue;
			}
			if ($key == 'verkoper' || $key == 'koper' || $key == 'looptijdEindeDag' || $key == 'looptijdEindeTijdstip' || $key == 'veilingGesloten' 
				|| $key == 'verkoopPrijs') continue;
			if ($key == 'looptijdBeginDag') {
				$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
				$htmlVeranderVoorwerp .= '<input type="date" name="'.$key.'" value="'.$value.'"><br>';	
				continue;
			} else if ($key == 'looptijdBeginDag') {
				$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
				$htmlVeranderVoorwerp .= '<input type="price" name="'.$key.'" value="'.$value.'"><br>';	
				continue;
			}
			$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
			$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
		}
		$htmlVeranderVoorwerp .= '<button class="btn btn-success" name="submit-changes-article">Sla wijzigingen op</button>';
		$htmlVeranderVoorwerp .= '<button class="btn btn-danger" name="delete-article">Verwijder voorwerp</button>';
		$htmlVeranderVoorwerp .= '</form>';
	} else if (isset($_GET['gebruikersnaamForm'])) {
		$htmlVeranderGebruiker = '<form class="form-group" method="GET" action="">'; 
		
		$_SESSION['username_changeinfo'] = $_GET['gebruikersnaamForm'];
		$parametersGebruiker = array(':gebruiker' => $_SESSION['username_changeinfo']);
		$kweerie2 = "SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruiker";
		$query = FetchAssocSelectData($kweerie2, $parametersGebruiker);
		foreach ($query as $key => $value) {
			if ($key == 'wachtwoord' || $key == 'vraag' || $key == 'soortGebruiker' || $key == 'antwoordtekst') continue; //Zodat de admin het wachtwoord niet kan zien
			$htmlVeranderGebruiker .= '<label>'. $key . '</label>';
			$htmlVeranderGebruiker .= '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
			
		}
		$htmlVeranderGebruiker .= '<button class="btn btn-success" name="submit-changes-user">Sla wijzigingen op</button>';
		$htmlVeranderGebruiker .= '<button name="block-user" class="btn btn-danger">Blokkeer gebruiker</button>';
		$htmlVeranderGebruiker .= '</form>';
	} else if (isset($_GET['block-user'])){
		deleteUser(array_values($_GET)[0]);	
	} else if (isset($_GET['delete-article'])){
		deleteArticle(array_values($_GET)[0]);
	} else if (isset($_GET['submit-changes-user'])){
		$birthdate = $_GET['geboortedag'];
		$myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
		$geboortedag = $myDateTime->format('Y-m-d');
		
		$changeUserParam = array(':usernameNew' => array_values($_GET)[0],
			':firstname' => $_GET['voornaam'],
			':lastname' => $_GET['achternaam'],
			':adres1' => $_GET['adresregel1'],
			':adres2' => $_GET['adresregel2'],
			':postcode' => $_GET['postcode'],
			':placename' => $_GET['plaatsnaam'],
			':country' => $_GET['land'],
			':birthdate' => $geboortedag,
			':mail' => $_GET['mailadres'],
			'usernameOld' => $_SESSION['username_changeinfo']);
		handlequery("UPDATE Gebruiker 
			SET gebruikersnaam = :usernameNew, voornaam = :firstname, achternaam = :lastname, adresregel1 = :adres1, adresregel2 = :adres2, postcode = :postcode, plaatsnaam = :placename, land = :country, geboortedag = :birthdate, mailadres = :mail
			WHERE gebruikersnaam = :usernameOld", $changeUserParam);	
		header("Location: ./admin-pagina.php");
		echo '<script language="javascript">';
		echo 'alert("Gegevens zijn gewijzigd")';
		echo '</script>';
	} else if (isset($_GET['submit-changes-article'])){
		$dateLooptijdBegin = $_GET['looptijdBeginDag'];
		$myDateTimeBegin = DateTime::createFromFormat('Y-m-d', $dateLooptijdBegin);
		$datumLooptijdBegin = $myDateTimeBegin->format('Y-m-d');
		$parametersUpdate = array(
			':titel' => $_GET['titel'], 
			':beschrijving' => $_GET['beschrijving'],
			':startprijs' => (int)$_GET['startprijs'],
			':betalingswijze' => $_GET['betalingswijze'],
			':betalingsinstructie' => $_GET['betalingsinstructie'],
			':plaatsnaam' => $_GET['plaatsnaam'],
			':land' => $_GET['land'],
			':looptijd' => $_GET['looptijd'],
			':looptijdbeginDag' => $datumLooptijdBegin,
			':looptijdbeginTijdstip' => $_GET['looptijdBeginTijdstip'],
			':verzendkosten' => (int)$_GET['verzendkosten'],
			':verzendinstructies' => $_GET['verzendinstructies'],
			':voorwerpnummer' => $_GET['voorwerpnummer']);
		handlequery("UPDATE Voorwerp SET
			titel = :titel,
			beschrijving = :beschrijving,
			startprijs = :startprijs,
			betalingswijze = :betalingswijze,
			betalingsinstructie = :betalingsinstructie,
			plaatsnaam = :plaatsnaam,
			land = :land,
			looptijd = :looptijd,
			looptijdbeginDag = :looptijdbeginDag,
			looptijdbeginTijdstip = :looptijdbeginTijdstip,
			verzendkosten = :verzendkosten,
			verzendinstructies = :verzendinstructies
			WHERE voorwerpnummer = :voorwerpnummer",
			$parametersUpdate);
	}
	?>

	<main>
		<div class="container">
			<div class="row">
				<div class="col-6">
					<div class="artikelnummer">
						<!-- form om te zoeken op artikelnummer -->
						<div class="col-lg-4">
							<form class="form-group" method="GET" action=""> 
								<input type="number" name="voorwerp" placeholder="Voorwerpnummer" min="0"> <br>
								<input class="cta-orange" name="zoekenVoorwerp" type="submit" value="Zoeken">
							</form>
						</div>
						<?=$htmlVeranderVoorwerp?>
					</div>
					<?php if(isset($artikelResultaten)) { 
						echo $artikelResultaten; 
					}?>
				</div>
				<div class="col-6">
					<div class="gebruiker">
						<!-- for om te zoeken op gebruiker -->
						<div class="col-lg-4">
							<form class="form-group" method="GET" action=""> 
								<input type="text" name="gebruiker" placeholder="Gebruikersnaam"> <br>
								<input class="cta-orange" name="zoekenGebruiker" type="submit" value="Zoeken">
							</form>
						</div>
						<?=$htmlVeranderGebruiker?>
					</div>
					<?php if(isset($gebruikerResultaten)) { 
						echo $gebruikerResultaten; 
					}?>
				</div>
			</div>
		</div>
	</main>
	
	<?php } require_once './footer.php'; ?>