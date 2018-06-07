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
          <div class="form-group">
            <label>Voorwerpnummer</label>
            <input class="voorwerpnummer" type="text" name="voorwerpnummer" value="" readonly><br>
          </div>

          <div class="form-group">
            <label>Bedrag</label>
            <input class="bodbedrag" type="number" name="bodbedrag" value=""  step=".01" min="0"><br>
          </div>

          <div class="form-group">
            <label>Datum</label>
            <input class="datum" type="date" name="datum" value=""><br>
          </div>

          <div class="form-group">
            <label>Tijd</label>
            <input class="tijd" type="text" name="tijd" value=""><br>
          </div>
          <input class="bodBedragOud" type="hidden" name="bodBedragOud" value="" step=".01" min="0"><br>
          <input class="gebruikersnaam" type="hidden" name="gebruikersnaam" value=""><br>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
            <button type="submit" class="btn btn-primary" name="submit-bit">Bijwerken</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>