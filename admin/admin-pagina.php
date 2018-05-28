<?php 
require_once './header.php'; 

if($_SESSION['gebruikersnaam'] == "admin") { 
	$htmlVeranderVoorwerp = ' ';
	$htmlVeranderGebruiker = ' ';
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
			<a href='?&voorwerpForm=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['titel'] ."</a>
			</td>
			<td>
			<a href='?&voorwerpForm=" . $voorwerp['voorwerpnummer'] . "'>" . $voorwerp['voorwerpnummer'] ."</a>
			</td>
			</tr>"; 
		} 
		$artikelResultaten .= '</tr></table>';
	} else if (isset($_GET['search-user'])) {
		$gebruikersnaam = $_GET['gebruiker'];
		$parametersGebruiker = array(':gebruiker' => "%". $gebruikersnaam ."%",
			':mail' => "%". $gebruikersnaam ."%",
			':plaats' => "%". $gebruikersnaam ."%");

		$gebruikers = handlequery("SELECT * 
			FROM Gebruiker 
			WHERE gebruikersnaam like :gebruiker
			OR mailadres like :mail
			OR plaatsnaam like :plaats",$parametersGebruiker);
		$gebruikerResultaten = '<table class="table"><tr><th scope="col">Resultaat</th></tr><tr>';
		foreach($gebruikers as $gebruiker){
			$gebruikerResultaten .= "<tr>" . "<td>" . "<a href='?gebruikersnaamForm=" . $gebruiker['gebruikersnaam'] . "'>" . $gebruiker['gebruikersnaam'] ."</a>". "</td>" . "</tr>";
		} 
		$gebruikerResultaten .= '</tr></table>';
	} else if (isset($_GET['search-bieding'])) {
		$biedingInput = $_GET['bieding'];	
		$parametersbieding = array(':voorwerpnummer' => (int)$biedingInput,
			'bodbedrag' => (int)$biedingInput,
			'titel' => "%". $biedingInput ."%");
		$biedingen = handlequery("SELECT * 
			FROM Bod B INNER JOIN Voorwerp V 
			ON B.voorwerpnummer = V.voorwerpnummer
			WHERE B.voorwerpNummer = :voorwerpnummer
			OR bodbedrag = :bodbedrag
			OR titel like :titel",
			$parametersbieding);
		$biedingenResultaten = '<table class="table"><tr><th scope="col">Resultaat</th></tr>';
		foreach($biedingen as $bieding){
			$biedingenResultaten .= "<tr>
			<td>
			<a href=?biedingsNummer=".$bieding['voorwerpnummer']."&biedingsTitel=".$bieding['titel']."&biedingsBedrag=".$bieding['bodbedrag'].">".$bieding['voorwerpnummer']."</a>
			</td>
			<td>
			<a href=?biedingsNummer=".$bieding['voorwerpnummer']."&biedingsTitel=".$bieding['titel']."&biedingsBedrag=".$bieding['bodbedrag'].">".$bieding['titel']."</a>
			</td>
			<td>
			<a href=?biedingsNummer=".$bieding['voorwerpnummer']."&biedingsTitel=".$bieding['titel']."&biedingsBedrag=".$bieding['bodbedrag'].">€".$bieding['bodbedrag']."</a>
			</td>
			</tr>";
		} 
		$biedingenResultaten .= '</table>';
	}
	if (isset($_GET['voorwerpForm'])) {
		$voorwerpDetailParam = array(':voorwerpnummer' => $_GET['voorwerpForm']);
		$artikelResultaten = ' ';
		$voorwerpDetailQuery = "SELECT voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, looptijdbeginDag, CONVERT(TIME(0), [looptijdbeginTijdstip]) as looptijdbeginTijdstip, verzendkosten, verzendinstructies 
		FROM Voorwerp 
		WHERE voorwerpnummer = :voorwerpnummer";
		$query = FetchAssocSelectData($voorwerpDetailQuery, $voorwerpDetailParam);

		$htmlVeranderVoorwerp = '<form class="form-group change-form" method="GET" action="">'; 
		foreach ($query as $key => $value) {
			$htmlVeranderVoorwerp .= '<div class="form-group">';		
			$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
			switch ($key) {
				case 'voorwerpnummer':
				$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				break;
				case 'looptijdbeginDag':
				$htmlVeranderVoorwerp .= '<input type="date" name="'.$key.'" value="'.$value.'"><br>';
				break;
				case 'looptijd':
				$htmlVeranderVoorwerp .= '<select name="'.$key.'">
				<option value="1">1</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="7">7</option>
				<option value="10">10</option>
				</select><br>';	
				break;
				default:
				$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
				break;
			}
			$htmlVeranderVoorwerp .= '</div>';
		}
		$htmlVeranderVoorwerp .= '<button class="btn btn-success" name="submit-changes-article">Sla wijzigingen op</button>';
		$htmlVeranderVoorwerp .= '<button class="btn btn-danger" name="delete-article">Verwijder voorwerp</button>';
		$htmlVeranderVoorwerp .= '</form>';
	} else if (isset($_GET['gebruikersnaamForm'])) {
		$_SESSION['username_changeinfo'] = $_GET['gebruikersnaamForm'];
		$parametersGebruiker = array(':gebruiker' => $_SESSION['username_changeinfo']);
		$queryGetUserInfo = "SELECT gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mailadres FROM Gebruiker WHERE gebruikersnaam = :gebruiker";
		$query = FetchAssocSelectData($queryGetUserInfo, $parametersGebruiker);
		$_SESSION['mail_changeinfo'] = $query['mailadres'];

		$htmlVeranderGebruiker = '<form class="form-group" method="GET" action="">'; 
		foreach ($query as $key => $value) {
			$htmlVeranderGebruiker .= '<div class="form-group">';
			$htmlVeranderGebruiker .= '<label>'. $key . '</label>';
			switch ($key) {
				case 'gebruikersnaam':
				$htmlVeranderGebruiker .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				break;
				default:
				$htmlVeranderGebruiker .= '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
				break;
			}
			$htmlVeranderGebruiker .= '</div>';
		}
		$htmlVeranderGebruiker .= '<button class="btn btn-success" name="submit-changes-user">Sla wijzigingen op</button>';
		$htmlVeranderGebruiker .= '<button name="block-user" class="btn btn-danger">Blokkeer gebruiker</button>';
		$htmlVeranderGebruiker .= '</form>';
	} else if (isset($_GET['biedingsNummer'])){
		$_SESSION['bit_changeinfo'] = $_GET['biedingsBedrag'];
		
		$parametersBied = array(':nummer' => (int)$_GET['biedingsNummer'],
								':bedrag' => $_GET['biedingsBedrag']);
		$queryBit = "SELECT voorwerpnummer, gebruikersnaam, bodbedrag, bodDag, CONVERT(TIME(0), [bodTijdstip]) as bodTijdstip
		FROM Bod 
		WHERE voorwerpnummer = :nummer
		AND bodbedrag = :bedrag";
		$query = FetchAssocSelectData($queryBit, $parametersBied);
		
		$htmlVeranderBieding = '<form class="form-group change-form" method="GET" action="">'; 
		foreach ($query as $field => $value) {			
			$htmlVeranderBieding .= '<div class="form-group">';
			$htmlVeranderBieding .= '<label>'. $field. '</label>';
			switch ($field) {
				case 'voorwerpnummer':
				case 'gebruikersnaam':
				$htmlVeranderBieding .= '<input type="text" name="'. $field.'" value="'. $value.'" readonly><br>';
				break;
				case 'bodDag':
				$htmlVeranderBieding .= '<input type="date" name="'. $field.'" value="'. $value.'"><br>';
				break;
				case 'bodTijdstip':
				$htmlVeranderBieding .= '<input type="text" name="'. $field.'" value="'. $value.'"><br>';
				break;
				case 'bodbedrag':
				$htmlVeranderBieding .= '<input type="number" name="'. $field.'" value="'. $value.'" step=".01" min="0"><br>';
				break;
			}
			$htmlVeranderBieding .= '</div>';
		}
		$htmlVeranderBieding .= '<button class="btn btn-success" name="submit-changes-bit">Sla wijzigingen op</button>';
		$htmlVeranderBieding .= '</form>';	
	} else if (isset($_GET['block-user'])){

		blockUser(array_values($_GET)[0]);	
		$errorMessageUser = "De gekozen gebruiker is geblokkeerd";
	} else if (isset($_GET['delete-article'])){
		deleteArticle(array_values($_GET)[0]);
		$errorMessageArticle = "Het gekozen artikel is verwijderd";
	} else if (isset($_GET['submit-changes-user'])){
		$birthdate = $_GET['geboortedag'];
		$myDateTime = DateTime::createFromFormat('Y-m-d', $birthdate);
		$geboortedag = $myDateTime->format('Y-m-d');
		if($_SESSION['mail_changeinfo'] == $_GET['mailadres']){
			$changeUserParam = array(':username' => $_GET['gebruikersnaam'], ':firstname' => $_GET['voornaam'], ':lastname' => $_GET['achternaam'], ':adres1' => $_GET['adresregel1'], ':adres2' => $_GET['adresregel2'], ':postcode' => $_GET['postcode'], ':placename' => $_GET['plaatsnaam'], ':country' => $_GET['land'], ':birthdate' => $geboortedag);
			handlequery("UPDATE Gebruiker 
						 SET voornaam = :firstname, achternaam = :lastname, adresregel1 = :adres1, adresregel2 = :adres2, postcode = :postcode, plaatsnaam = :placename, land = :country, geboortedag = :birthdate
						 WHERE gebruikersnaam = :username", $changeUserParam);
		} else {
			if(checkEmailUnique($_GET['mailadres'])){
				$changeUserParam = array(':username' => $_GET['gebruikersnaam'], ':firstname' => $_GET['voornaam'], ':lastname' => $_GET['achternaam'], ':adres1' => $_GET['adresregel1'], ':adres2' => $_GET['adresregel2'], ':postcode' => $_GET['postcode'], ':placename' => $_GET['plaatsnaam'], ':country' => $_GET['land'], ':birthdate' => $geboortedag, ':mail' => $_GET['mailadres']);
				handlequery("UPDATE Gebruiker 
							 SET voornaam = :firstname, achternaam = :lastname, adresregel1 = :adres1, adresregel2 = :adres2, postcode = :postcode, plaatsnaam = :placename, land = :country, geboortedag = :birthdate, mailadres = :mail
							 WHERE gebruikersnaam = :username", $changeUserParam);
				$errorMessageUser = "Wijzigingen zijn opgeslagen";
			} else {
				$errorMessageUser = "Mailadres is al in gebruik";
			}

		}
	} else if (isset($_GET['submit-changes-article'])){
		$dateLooptijdBegin = $_GET['looptijdbeginDag'];
		$myDateTimeBegin = DateTime::createFromFormat('Y-m-d', $dateLooptijdBegin);
		$datumLooptijdBegin = $myDateTimeBegin->format('Y-m-d');
		$parametersUpdate = array(':titel' => $_GET['titel'], ':beschrijving' => $_GET['beschrijving'], ':startprijs' => (float)$_GET['startprijs'], ':betalingswijze' => $_GET['betalingswijze'], ':betalingsinstructie' => $_GET['betalingsinstructie'], ':plaatsnaam' => $_GET['plaatsnaam'], ':land' => $_GET['land'], ':looptijd' => $_GET['looptijd'], ':looptijdbeginDag' => $datumLooptijdBegin, ':looptijdbeginTijdstip' => $_GET['looptijdbeginTijdstip'], ':verzendkosten' => (float)$_GET['verzendkosten'], ':verzendinstructies' => $_GET['verzendinstructies'], ':voorwerpnummer' => $_GET['voorwerpnummer']);
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
		$errorMessageArticle = "Wijzigingen aan artikel zijn opgeslagen";
	} else if (isset($_GET['submit-changes-bit'])){
		$dateBitDate = $_GET['bodDag'];
		$myDateTimeBegin = DateTime::createFromFormat('Y-m-d', $dateBitDate);
		$datumBoddag = $myDateTimeBegin->format('Y-m-d');
		$changeBitParam = array(':nummer' => $_GET['voorwerpnummer'],
			':gebruikersnaam' => $_GET['gebruikersnaam'],
			':bedrag' => (float)$_GET['bodbedrag'],
			':dag' => $datumBoddag,
			':tijdstip' => $_GET['bodTijdstip'],
			':bedragOud' => $_SESSION['bit_changeinfo']);
		$changeBitCheckParam = array(':nummer' => $_GET['voorwerpnummer'],
			':gebruikersnaam' => $_GET['gebruikersnaam'],
			':bedrag' => (float)$_GET['bodbedrag'],
			':dag' => $datumBoddag,
			':tijdstip' => $_GET['bodTijdstip']);
		$changeBitQuery = "UPDATE Bod SET bodbedrag = :bedrag, bodDag = :dag, bodTijdstip = :tijdstip WHERE gebruikersnaam = :gebruikersnaam AND bodbedrag = :bedragOud AND voorwerpnummer = :nummer";

		$queryChangedBitCheck = handlequery("SELECT * FROM Bod WHERE voorwerpnummer = :nummer AND gebruikersnaam = :gebruikersnaam AND bodbedrag = :bedrag AND bodDag = :dag AND bodTijdstip = :tijdstip", $changeBitCheckParam);

		if(empty($queryChangedBitCheck)) {
			handlequery($changeBitQuery, $changeBitParam);
		} else {
			$errorMessageBit = "Dit bod bestaat al. Kies een ander bedrag.";
		}
	}
	?>

	<main class="beheerdersomgeving">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-sm-12">
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
				<div class="col-lg-4 col-sm-12">
					<div class="gebruiker">
						<!-- for om te zoeken op gebruiker -->
						<form class="form-group" method="GET" action=""> 
							<input type="text" name="gebruiker" placeholder="Gebruiker"> <br>
							<input class="cta-orange" name="search-user" type="submit" value="Zoeken">
						</form>
						<?php if(isset($errorMessageUser)) { 
							echo '<p class="error error-warning">'.$errorMessageUser.'</p>'; 
						}
						echo $htmlVeranderGebruiker;
						?>
					</div>
					<?php if(isset($gebruikerResultaten)) { 
						echo $gebruikerResultaten; 
					}?>
				</div>
				<div class="col-lg-4 col-m-12">
					<div class="bieding">
						<!-- for om te zoeken op gebruiker -->
						<form class="form-group" method="GET" action=""> 
							<input type="text" name="bieding" placeholder="Bieding"> <br>
							<input class="cta-orange" name="search-bieding" type="submit" value="Zoeken">
						</form>
						<?php if(isset($errorMessageBit)) { 
							echo '<p class="error error-warning">'.$errorMessageBit.'</p>'; 
						}
						echo $htmlVeranderBieding;
						?>
					</div>
					<?php if(isset($biedingenResultaten)) { 
						echo $biedingenResultaten; 
					}?>
				</div>
			</div>
		</div>
	</main>

<?php } 
require_once './footer.php'; ?>