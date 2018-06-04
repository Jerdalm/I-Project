<!-- Modal -->
<div class="modal fade" id="changeColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog " role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Info bijwerken</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- echo om alle data in een formulier te zetten en te zorgen dat de gegevens aangepast kunnen worden. -->
				<form method="get" class="form-group col-lg-12 edit-column-info">  
					<label>Rubrieknaam</label>
					<input type="text" class="columnname" name="columnname" value="">
					<input type="hidden" class="rubrieknummer" name="rubrieknummer" value="">
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
						<button type="submit" class="btn btn-primary" name="change-column-name">Bijwerken</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
