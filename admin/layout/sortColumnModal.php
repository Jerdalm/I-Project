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
							echo '<option value="'.$key.'">'.$key['rubrieknaam'].'</option>';		
						}
						?>
					</select>

					<select name="select2" id="select2">
						<?php 
						foreach (returnColumns(1) as $key) {
							echo '<option value="'.$key.'">'.$key['rubrieknaam'].'</option>';		
						}
						?>
					</select>

				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$("#select2").hide();

		$("#select1").change(function(){
			if($(this).val() != "Maak een keuze..."){
				$("#select2").show();
			}else{
				$("#select2").hide();
			}

		});
	})
</script>