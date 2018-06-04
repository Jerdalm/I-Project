<?php
if (isset($_GET['rubriek'])) {
	if (is_numeric($_GET['rubriek'])) {
		$rubriekDetailParam = array(':nummer' => (int)$_GET['rubriek'],
								':naam' => null);
	} else {
		$rubriekDetailParam = array(':nummer' => '-9000',
								':naam' => "%".$_GET['rubriek']."%");
	}
	$queryGetRubriekInfo = "SELECT * 
	FROM rubriek 
	WHERE rubrieknummer = :nummer
	or rubrieknaam like :naam";
	$query = FetchAssocSelectData($queryGetRubriekInfo, $rubriekDetailParam);
	
	if (count($query) > 1) {
		$htmlToonRubriekInfo = '<form class="form-group" method="GET" action="">'; 
		foreach ($query as $key => $value) {
			$htmlToonRubriekInfo .= '<div class="form-group">';
			$htmlToonRubriekInfo .= '<label>'. $key . '</label>';
			$htmlToonRubriekInfo .= '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
			$htmlToonRubriekInfo .= '</div>';
		}
		$htmlToonRubriekInfo .= '</form>'; ?>
		<div class="tab-pane fade show active col float-left" id="rubriekinfo" role="tabpanel" aria-labelledby="list-columninfo">
			<div class="tab-pane fade show active" id="gebruikers" role="tabpanel" aria-labelledby="list-product-details">
				<h2>Rubriekinformatie</h2>
				<form class="form-group change-form" method="GET" action="">
					<?php if(isset($htmlToonRubriekInfo)){ echo $htmlToonRubriekInfo;}?>
					<button type="button" class="btn btn btn-success" data-toggle="modal" data-naam="<?=$query['rubrieknaam']?>" data-nummer="<?=$query['rubrieknummer']?>"  data-target="#changeColumn">Hernoem rubriek</button>		
					<button type="button" class="btn btn btn-secondary" data-toggle="modal" data-target="#sortColumn">Sorteer product</button>					
					<?php require 'layout/changeColumnModal.php';
					 	require 'layout/sortColumnModal.php';?>
				</form>
			</div>
		</div>
	<?php 
	}
}
if (isset($_GET['change-column-name']) && isset($_GET['columnname']) && isset($_GET['rubrieknummer'])) {
	updateColumnName($_GET);
}
?>