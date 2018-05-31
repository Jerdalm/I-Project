<?php
if (isset($_GET['rubriek'])) {
	$rubriekDetailParam = array(':nummer' => $_GET['rubriek']);
	$queryGetRubriekInfo = "SELECT * 
	FROM rubriek 
	WHERE rubrieknummer = :nummer";
	$query = FetchAssocSelectData($queryGetRubriekInfo, $rubriekDetailParam);
	
	if (count($query) > 1) {
		$htmlToonRubriekInfo = '<form class="form-group" method="GET" action="">'; 
		foreach ($query as $key => $value) {
			$htmlToonRubriekInfo .= '<div class="form-group">';
			$htmlToonRubriekInfo .= '<label>'. $key . '</label>';
			$htmlToonRubriekInfo .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
			$htmlToonRubriekInfo .= '</div>';
		}
		$htmlToonRubriekInfo .= '</form>';	?>

		<div class="tab-pane fade show active col-lg-9 col-sm-12 float-left" id="rubriekinfo" role="tabpanel" aria-labelledby="list-columninfo">
			<div class="tab-pane fade show active" id="gebruikers" role="tabpanel" aria-labelledby="list-product-details">
				<h2>Rubriekiformatie</h2>
				<form class="form-group change-form" method="GET" action="">
					<?php if(isset($htmlToonRubriekInfo)){ echo $htmlToonRubriekInfo;}?>
					<button type="button" class="btn btn btn-success" data-toggle="modal" data-target="#changeUser">Bewerk gegevens</button>
					<?php require 'layout/changeUserModal.php';?>
				</form>
			</div>
		</div>
	<?php 
		// if (isset($_GET['bijwerken'])) {
		// 	UpdateInfoUser($_GET, $_GET['gebruikersnaam'],$gebruiker);
		// }
	}
}
?>