<!-- Modal -->
<div class="modal fade" id="changeInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Info bijwerken</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
            <form method="get" class="form-group col-lg-12 edit-user-info">  
                <?php  foreach ($gebruiker as $key => $value) { 
                    echo '<label><b>'.$key.'</b></label>';
                    switch ($key) {
                        case 'geboortedag':
                        echo '<input class="form-control" type="date" name="' . $key . '" value="'. $value .'" required><br>';
                        break;
                        case 'gebruikersnaam':
                        echo '<input class="form-control" type="text" name="' . $key . '" value="'. $value .'" readonly><br>';
                        break;
                        case 'telefoonnummer':
                        echo '<input class="form-control" type="tel" name="' . $key . '" value="'. $value .'" required><br>';
                        break;
                        default:
                        echo '<input class="form-control" type="text" name="' . $key . '" value="'. $value .'" required><br>';
                        break;
                    }
                } 
					
		?>
           
	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
        <button type="submit" class="btn btn-primary" name="bijwerken">Bijwerken</button>
      </div>
	  </form>
	</form>
    </div>
  </div>
</div>