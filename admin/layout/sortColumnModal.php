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
					
					<select class="selectpicker" data-live-search="true">
						<option value="Maak een keuze...">Maak een keuze...</option>
						<?php 

						foreach ($queryGetColumns as $option => $value) {			
							echo '<option data-tokens="'.$value['rubrieknaam']	.'" val="'.$value['rubrieknummer'].'">'.$value['rubrieknaam'].'</option>';
						}
						?>
					</select>

				</form>
			</div>
		</div>
	</div>
</div>