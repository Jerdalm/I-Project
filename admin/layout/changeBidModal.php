<div class="modal hide fade" id="changeBid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Info bijwerken</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="get" class="form-inline edit-product-info">
        <div class="modal-body">
          <!-- echo om alle data in een formulier te zetten en te zorgen dat de gegevens aangepast kunnen worden. -->
          <?php foreach ($biedings as $field => $value) { 
            echo '<div class="form-group">';
            echo '<label>'. $field. '</label>';
            switch ($field) {
              case 'voorwerpnummer':
              case 'gebruikersnaam':
              echo '<input type="text" name="'. $field.'" value="'. $value.'" readonly><br>';
              break;
              case 'Datum':
              echo '<input type="date" name="'. $field.'" value="'. $value.'"><br>';
              break;
              case 'Tijd':
              echo '<input type="text" name="'. $field.'" value="'. $value.'"><br>';
              break;
              case 'bodbedrag':
              echo '<input type="number" name="'. $field.'" id="'.$field.'" value="'. $value.'" step=".01" min="0"><br>';
              break;
            }
            echo '</div>';
          }
          
          ?>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            <button type="submit" class="btn btn-primary" name="submit-bit">Bijwerken</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>