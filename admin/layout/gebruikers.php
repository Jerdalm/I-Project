<?php
if (isset($_GET['gebruikersnaam'])) {
	$gebruikerDetailParam = array(':naam' => $_GET['gebruikersnaam']);
	$queryGetUserInfo = "SELECT gebruikersnaam, voornaam, achternaam, plaatsnaam, land, geboortedag, mailadres, soortGebruiker
	FROM Gebruiker 
	WHERE gebruikersnaam = :naam";
	$query = FetchAssocSelectData($queryGetUserInfo, $gebruikerDetailParam);
	
	if (count($query) > 1) {
		$emailParameters = array(':gebruikersnaam' => $_GET['gebruikersnaam']);
		$gebruiker = FetchAssocSelectData("SELECT TOP 1 Gebruiker.gebruikersnaam,voornaam,achternaam,adresregel1,adresregel2,postcode,plaatsnaam,land,geboortedag,mailadres,telefoonnummer FROM Gebruiker 
			LEFT join Gebruikerstelefoon on Gebruiker.gebruikersnaam = Gebruikerstelefoon.gebruikersnaam
			WHERE Gebruiker.gebruikersnaam = :gebruikersnaam", $emailParameters);
		$htmlToonProductInfo = '<form class="form-group" method="GET" action="">'; 
		foreach ($query as $key => $value) {
			$htmlToonProductInfo .= '<div class="form-group">';
			$htmlToonProductInfo .= '<label>'. $key . '</label>';
			switch ($key) {
				case 'gebruikersnaam':
				$htmlToonProductInfo .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				break;
				case 'geboortedag':
				$htmlToonProductInfo .= '<input type="text" name="'.$key.'" value="'.date("d-m-Y", strtotime($value)).'" readonly><br>';
				continue;
				default:
				$htmlToonProductInfo .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
				break;
			}
			$htmlToonProductInfo .= '</div>';
		}
		$htmlToonProductInfo .= '</form>';	?>

		<div class="tab-pane fade show active col-lg-9 col-sm-12 float-left" id="gebruikers" role="tabpanel" aria-labelledby="list-product-list">
			<div class="tab-pane fade show active" id="gebruikers" role="tabpanel" aria-labelledby="list-product-details">
				<h2>Gebruikerinformatie</h2>
				<form class="form-group change-form" method="GET" action="">
					<?php if(isset($htmlToonProductInfo)){ echo $htmlToonProductInfo;}?>
					<button type="button" class="btn btn btn-success" data-toggle="modal" data-target="#changeUser">Bewerk gegevens</button>
					<?php require 'layout/changeUserModal.php';?>
				</form>
			</div>
		</div>
	<?php 
		if (isset($_GET['bijwerken'])) {
			UpdateInfoUser($_GET, $_GET['gebruikersnaam'],$gebruiker);
		}
	} else {
		echo "<h1>Gebruik bestaat niet :(</h1>";
	}
}
?>