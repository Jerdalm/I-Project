<!-- Modal -->
<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Wachtwoord wijzigen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="formWachtwoordHuidig ">
          <form method="POST" class="" action="">
            <div class="form-group col-lg-12">
              <label for="testvoorvraag"> Huidig Wachtwoord </label>
              <input type="password" name="huidigWachtwoord" class="form-control" id="testAntwoordvakje" placeholder="Voer hier uw huidige wachtwoord in">
            </div>
            <div class="form-group col-lg-12">
              <label for="registration-password">Wachtwoord</label>
              <input type="password" placeholder="Voer uw nieuwe wachtwoord in" class="form-control" name="password" id="registration-password">
            </div>
            <div class="form-group col-lg-12">
              <label for="password-repeat">Herhaal wachtwoord</label>
              <input type="password" class="form-control" placeholder="Herhaal uw nieuwe wachtwoord" name="password-repeat" id="password-repeat">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
              <button type="submit" id="button-submit" name="submit-new-password" value="Register" class="btn btn-primary">Wijzigen</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>