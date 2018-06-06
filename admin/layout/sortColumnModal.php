<?php
$queryGetColumns = handlequery("SELECT * FROM rubriek ORDER BY rubrieknaam asc");
?>

<div class="modal fade" id="sortColumn" tabindex="-1" role="dialog" aria-labelledby="label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="label">Info bijwerken</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">				
				<form>				
					<select class="form-control" name="resort-column">
						<option value="Maak een keuze..." disabled selected>Maak een keuze...</option>
						<?php 
						foreach ($queryGetColumns as $option => $value) {			
							echo '<option value="'.$value['rubrieknummer'].'">'.$value['rubrieknaam'].'</option>';
						}
						?>
					</select>
					<br>
					<input type="hidden" class="rubrieknummer" name="rubrieknummer" value="">
					<button class="btn btn-success">Sorteer veiling</button>
				</form>
			</div>
		</div>
	</div>
</div>