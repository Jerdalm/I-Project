<?php 

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
					<select name="select1" id="select1">
						<option class="select" selected value="Maak een keuze...">Maak een keuze...</option>						
						<?php 
						foreach (returnColumns(-1) as $key) {
							echo '<option value="'.$key['rubrieknummer'].'">'.$key['rubrieknaam'].'</option>';		
						}
						?>
					</select>

					<select name="select2" id="select2">
						<option class="select" selected value="Maak een keuze...">Maak een keuze...</option>	
						<?php 
						foreach (returnColumns(1) as $key) {
							echo '<option value="'.$key['rubrieknummer'].'">'.$key['rubrieknaam'].'</option>';		
						}
						?>
					</select>
					<button name="btn-sort" id="btn-sort" class="btn btn-success btn-sort">Sorteer op deze categorie</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#select2").hide();
		$("#btn-sort").hide();

		$("#select1").change(function(){
			if ($(this).val() != "Maak een keuze..."){
				$("#select2").show();
				$("#btn-sort").show();
				var value = $("#select1 option:selected").val();
			} else {
				$("#select2").hide();
				$("#btn-sort").hide();
			}

		});
	})
</script>