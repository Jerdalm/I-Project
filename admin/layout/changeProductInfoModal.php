<div class="modal hide fade" id="changeInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Info bijwerken</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- echo om alle data in een formulier te zetten en te zorgen dat de gegevens aangepast kunnen worden. -->
        <form method="get" class="form-inline edit-product-info">
          <?php foreach ($queryVoorwerpDetail as $key => $value) { 
            echo '<label><b>'.$key.'</b></label>';
            echo '<div class="form-group">';
            switch ($key) {
              case 'voorwerpnummer':
              echo '<input type="text" name="'.$key.'" value="'.$value.'" readonly><br>';
              break;
              case 'looptijdbeginDag':
              echo '<input type="date" name="'.$key.'" value="'.$value.'"><br>';
              break;
              case 'looptijd':
              echo '<select name="'.$key.'">
              <option value="1">1</option>
              <option value="3">3</option>
              <option value="5">5</option>
              <option value="7">7</option>
              <option value="10">10</option>
              </select><br>'; 
              break;
              default:
              echo '<input type="text" name="'.$key.'" value="'.$value.'"><br>';
              break;
            }
            echo '</div>';
          }
          ?>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
          <button type="submit" class="btn btn-primary" name="submit-product">Bijwerken</button>
        </form>
      </div>
    </div>
  </div>
</div>