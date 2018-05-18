<?php 
require_once './header.php'; 

if($_SESSION['gebruikersnaam'] == "admin") { 
	$htmlVeranderVoorwerp = ' ';
	$htmlVeranderGebruiker = ' ';
	$htmlVeranderBieding = ' ';
	$_SESSION['voorwerpnummer'] = ' ';
	if (isset($_GET['search-article'])){
		$voorwerpNummer = $_GET['voorwerp'];
		$parametersVoorwerp = array(':voorwerpnummer' => $voorwerpNummer);
		$voorwerpen = handlequery("SELECT * 
			FROM Voorwerp 
			WHERE voorwerpnummer = :voorwerpnummer",$parametersVoorwerp);		
		$artikelResultaten = '<table class="table"><tr><th scope="col">Voorwerp</th></tr><tr>';
		foreach($voorwerpen as $voorwerp){
			$getpath = "$_SERVER[QUERY_STRING]";
			$artikelResultaten .= "<tr>" . "<td>" . "<a href='?".$getpath."&voorwerpForm=" . $voorwerp['titel'] . "'>" . $voorwerp['titel'] ."</a>". "</td>"."</tr>"; 
		} 
		$artikelResultaten .= '</tr></table>';
	} else if (isset($_GET['search-user'])) {
		$gebruikersnaam = $_GET['gebruiker'];
		$parametersGebruiker = array(':gebruiker' => "%". $gebruikersnaam ."%",
			'mail' => "%". $gebruikersnaam ."%",
			'plaats' => "%". $gebruikersnaam ."%");

		$gebruikers = handlequery("SELECT * 
			FROM Gebruiker 
			WHERE gebruikersnaam like :gebruiker
			OR mailadres like :mail
			OR plaatsnaam like :plaats",$parametersGebruiker);
		// echo '<pre>';
		// print_r($gebruikers);
		// echo "</pre>";
		// die();
		$gebruikerResultaten = '<table class="table"><tr><th scope="col">Gebruikersnaam</th></tr><tr>';
		foreach($gebruikers as $gebruiker){
			$gebruikerResultaten .= "<tr>" . "<td>" . "<a href='?gebruikersnaamForm=" . $gebruiker['gebruikersnaam'] . "'>" . $gebruiker['gebruikersnaam'] ."</a>". "</td>" . "</tr>";
		} 
		$gebruikerResultaten .= '</tr></table>';
	} else if (isset($_GET['search-bieding'])) {
		$biedingInput = $_GET['bieding'];	
		$parametersbieding = array(':voorwerpnummer' => "%". $biedingInput ."%",
								   'bodbedrag' => "%". $biedingInput ."%",
								   'titel' => "%". $biedingInput ."%");
		$biedingen = handlequery("SELECT * 
								   FROM Bod B INNER JOIN Voorwerp V 
								   ON B.voorwerpnummer = V.voorwerpnummer
								   WHERE B.voorwerpNummer like :voorwerpnummer
								   OR bodbedrag like :bodbedrag
								   OR titel like :titel",$parametersbieding);
		$biedingenResultaten = '<table class="table"><tr><th scope="col">Biedingen</th></tr>';
		foreach($biedingen as $bieding){
			$biedingenResultaten .= "<tr>
										<td>
											<a href=?gebruikersnaamForm=".$bieding['voorwerpnummer']."'>".$bieding['voorwerpnummer']."</a>
										</td>
										<td>
											<a href=?gebruikersnaamForm=".$bieding['voorwerpnummer']."'>".$bieding['titel']."</a>
										</td>
										<td>
											<a href=?gebruikersnaamForm=".$bieding['voorwerpnummer']."'>€".$bieding['bodbedrag']."</a>
										</td>
									</tr>";
			// echo "<pre>";
			// print_r($bieding['titel']);
			// echo "</pre>";
			// die();
		} 
		$biedingenResultaten .= '</table>';
	}

	if (isset($_GET['voorwerpForm'])) {
		$artikelResultaten = ' ';
		$htmlVeranderVoorwerp = '<form class="form-group change-form" method="GET" action="">'; 

		$kweerie = "SELECT voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam, land, looptijd, looptijdbeginDag, 				looptijdbeginTijdstip, verzendkosten, verzendinstructies FROM Voorwerp WHERE voorwerpnummer = :voorwerpnummer";
		$query = FetchAssocSelectData($kweerie, $parametersVoorwerp);
		
		foreach ($query as $key => $value) {
			if ($key == 'voorwerpnummer') {		
				$htmlVeranderVoorwerp .= '<div class="change-form-group">';		
				$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
				$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				$htmlVeranderVoorwerp .= '</div>';
				continue;
			} else if ($key == 'looptijdbeginDag') {
				$htmlVeranderVoorwerp .= '<div class="change-form-group">';
				$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
				$htmlVeranderVoorwerp .= '<input type="date" name="'.$key.'" value="'.$value.'"><br>';
				$htmlVeranderVoorwerp .= '</div>';	
				continue;
			} 
			else if ($key == 'looptijd') {
				$htmlVeranderVoorwerp .= '<div class="change-form-group">';
				$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
				$htmlVeranderVoorwerp .= '<select name="'.$key.'">
				<option value="1">1</option>
				<option value="3">3</option>
				<option value="5">5</option>
				<option value="7">7</option>
				<option value="10">10</option>
				</select><br>';	
				$htmlVeranderVoorwerp .= '</div>';
				continue;
			}
			$htmlVeranderVoorwerp .= '<div class="change-form-group">';
			$htmlVeranderVoorwerp .= '<label>'. $key . '</label>';
			$htmlVeranderVoorwerp .= '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
			$htmlVeranderVoorwerp .= '</div>';
		}
		$htmlVeranderVoorwerp .= '<button class="btn btn-success" name="submit-changes-article">Sla wijzigingen op</button>';
		$htmlVeranderVoorwerp .= '<button class="btn btn-danger" name="delete-article">Verwijder voorwerp</button>';
		$htmlVeranderVoorwerp .= '</form>';
	} else if (isset($_GET['gebruikersnaamForm'])) {
		$htmlVeranderGebruiker = '<form class="form-group change-form" method="GET" action="">'; 
		
		$_SESSION['username_changeinfo'] = $_GET['gebruikersnaamForm'];
		$parametersGebruiker = array(':gebruiker' => $_SESSION['username_changeinfo']);
		$kweerie2 = "SELECT gebruikersnaam, voornaam, achternaam, adresregel1, adresregel2, postcode, plaatsnaam, land, geboortedag, mailadres FROM Gebruiker WHERE gebruikersnaam = :gebruiker";
		$query = FetchAssocSelectData($kweerie2, $parametersGebruiker);
		foreach ($query as $key => $value) {
			if ($key == 'gebruikersnaam'){
				$htmlVeranderGebruiker .= '<div class="change-form-group">';
				$htmlVeranderGebruiker .= '<label>'. $key . '</label>';
				$htmlVeranderGebruiker .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				$htmlVeranderGebruiker .= '</div>';
				continue;
			}
			$htmlVeranderGebruiker .= '<div class="change-form-group">';
			$htmlVeranderGebruiker .= '<label>'. $key . '</label>';
			$htmlVeranderGebruiker .= '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
			$htmlVeranderGebruiker .= '</div>';
			
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
		$dateLooptijdBegin = $_GET['looptijdbeginDag'];
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
			':looptijdbeginTijdstip' => $_GET['looptijdbeginTijdstip'],
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
				<div class="col-4">
					<div class="artikelnummer">
						<!-- form om te zoeken op artikelnummer -->
						
						<form class="form-group" method="GET" action=""> 
							<input type="number" name="voorwerp" placeholder="Voorwerpnummer" min="0"> <br>
							<input class="cta-orange" name="search-article" type="submit" value="Zoeken">
						</form>
						
						<?=$htmlVeranderVoorwerp?>
					</div>
					<?php if(isset($artikelResultaten)) { 
						echo $artikelResultaten; 
					}?>
				</div>
				<div class="col-4">
					<div class="gebruiker">
						<!-- for om te zoeken op gebruiker -->
						<form class="form-group" method="GET" action=""> 
							<input type="text" name="gebruiker" placeholder="Gebruiker"> <br>
							<input class="cta-orange" name="search-user" type="submit" value="Zoeken">
						</form>
						
						<?=$htmlVeranderGebruiker?>
					</div>
					<?php if(isset($gebruikerResultaten)) { 
						echo $gebruikerResultaten; 
					}?>
				</div>
				<div class="col-4">
					<div class="bieding">
						<!-- for om te zoeken op gebruiker -->
						<form class="form-group" method="GET" action=""> 
							<input type="text" name="bieding" placeholder="Bieding"> <br>
							<input class="cta-orange" name="search-bieding" type="submit" value="Zoeken">
						</form>
						
						<?=$htmlVeranderBieding?>
					</div>
					<?php if(isset($biedingenResultaten)) { 
						echo $biedingenResultaten; 
					}?>
				</div>
			</div>
		</div>
	</main>
	
	<?php } require_once './footer.php'; ?>