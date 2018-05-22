<?php require_once 'header.php'
if($_POST['sellitem']) {
  $selectUploadedItem = array(':titel' => $_POST['titel'],
  ':verkoper' => $_SESSION['gebruikersnaam'],
  ':startprijs' => $_POST['startprijs'],
  ':looptijd' => $_POST['loopijd']);
  $voorwerpnummer = handlequery(' SELECT Voorwerpnummer
    FROM Voorwerp
    WHERE Titel = :titel AND
    Verkoper = :verkoper AND
    Startprijs = :startprijs AND
    Looptijd = :looptijd
    ORDER BY looptijdEindeDag DESC,
    looptijdEindeTijdstip DESC', $selectUploadedItem);
    print_r($voorwerpnummer);
    header(Location: 'http://localhost/I-Project/productpage.php?product=' . $voorwerpnummer);
  }
  ?>
<main>
  <section class='uploadarticle'>
    <div class="container">
      <div class="row">
        <form class="" method="post">
          <!-- <fieldset> -->
          <legend>Voorwerp veilen!</legend>

          <div class="form-group">
            <label class="col-md-12 control-label" for="titel">Titel voor veiling</label>
            <div class="col-md-12">
              <input id="titel" name="titel" type="text" class="form-control input-md" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="beschrijving">Beschrijving</label>
            <div class="col-md-12">
              <textarea class="form-control" id="beschrijving" name="beschrijving" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="looptijd">Looptijd in dagen</label>
            <div class="col-md-4">
              <select id="looptijd" name="looptijd" class="form-control">
                <option value="1">1</option>
                <option value="3">3</option>
                <option value="5">5</option>
                <option value="7">7</option>
                <option value="10">10</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="startprijs">Startprijs in euro's</label>
            <div class="col-md-5">
              <input id="startprijs" name="startprijs" type="number" class="form-control input-md" required>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="betalingswijze">Betalingswijze</label>
            <div class="col-md-6">
              <select id="betalingswijze" name="betalingswijze" class="form-control">
                <option value="Credit Card">Credit Card</option>
                <option value="iDeal">iDeal</option>
                <option value="PayPal">PayPal</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="betalingsinstructie">Betalingsinstructie</label>
            <div class="col-md-12">
              <input id="betalingsinstructie" name="betalingsinstructie" type="text" placeholder="Optioneel" class="form-control input-md">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="verzendkosten">Verzendkosten</label>
            <div class="col-md-12">
              <input id="verzendkosten" name="verzendkosten" type="text" placeholder="Optioneel" class="form-control input-md">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="verzendinstructies">Verzendinstructies</label>
            <div class="col-md-12">
              <input id="verzendinstructies" name="verzendinstructies" type="text" placeholder="Optioneel" class="form-control input-md">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="uploadphoto">Upload foto</label>
            <div class="col-md-12">
              <input id="uploadphoto" name="uploadphoto" class="input-file" type="file">
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-12 control-label" for="verzenden"></label>
            <div class="col-md-12">
              <button id="sellitem" name="sellitem" type="submit" class="cta-orange">Verkopen!</button>
            </div>
          </div>
          <!-- </fieldset> -->
        </form>
      </div>
    </div>
  </section>



</main>

<?php require_once 'footer.php' ?>
