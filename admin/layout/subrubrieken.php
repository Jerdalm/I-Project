<?php
if (isset($_GET['rubriek'])) {
	$htmlToonSubrubrieken = ' ';
	$parametersrubrieken = array(':rubriek' => $_GET['rubriek']);
	$subrubrieken = handlequery("SELECT * FROM Rubriek WHERE hoofdrubriek = :rubriek ORDER BY rubrieknummer desc ", $parametersrubrieken);
	foreach($subrubrieken as $rubriek){
		$htmlToonSubrubrieken .= '<tr>
		<td>
		<p>'.$rubriek['rubrieknummer'].'</p>
		</td>
		<td>
		<p>'.$rubriek['rubrieknaam'].'</p>
		</td>
		<td>
		<a href=./change-column.php?rubriek='.$rubriek['rubrieknummer'].' class="btn btn-success" target="_blank">Ga naar rubriek</a>
		</td>
		</tr>';
	}?>

	<div class="tab-pane fade show col float-left" id="subrubrieken" role="tabpanel" aria-labelledby="list-subcolumns">
		<div class="tab-pane fade show active" id="gebruikers" role="tabpanel" aria-labelledby="list-product-details">
			<h2>Subrubrieken</h2>
			<table class="table striped">
			<tr>
				<th scope="col">Rubrieknummer</th>
				<th scope="col">Rubrieknummer</th>
				<th scope="col"></th>
			</tr>
			<?php if(isset($htmlToonSubrubrieken)){ echo $htmlToonSubrubrieken;} ?>
			<?php require 'layout/changeBidModal.php';?>
		</table>
		</div>
	</div>
	<?php 
		// if (isset($_GET['bijwerken'])) {
		// 	UpdateInfoUser($_GET, $_GET['gebruikersnaam'],$gebruiker);
		// }
}

?>