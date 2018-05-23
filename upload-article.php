<?php require_once 'header.php';

if (isset($_SESSION['gebruikersnaam'])) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $filledin = array(
    'titel',
    'beschrijving',
    'looptijd',
    'startprijs',
    'betalingswijze',
    'uploadfoto'
  );

  if (isset($_POST['sellitem']) && fieldsFilledIn($filledin)) {
    if (empty($_POST['betalingsinstructie'])) {
      $_POST['betalingsinstructie'] = NULL;
    } if (empty($_POST['verzendkosten'])) {
      $_POST['verzendkosten'] = NULL;
    } if (empty($_POST['verzendinstructies'])) {
      $_POST['verzendinstructies'] = NULL;
    }

    $voorwerpnummerUpload = handlequery("SELECT MAX(voorwerpnummer)+1 AS nieuwVoorwerpnummer FROM Voorwerp");
    $plaats = handlequery("SELECT plaatsnaam, land FROM Gebruiker WHERE gebruikersnaam = '".$_SESSION['gebruikersnaam']."'");

    $uploadItem = array(
      ':voorwerpnummer' => $voorwerpnummerUpload[0]['nieuwVoorwerpnummer'],
      ':titel' => $_POST['titel'],
      ':beschrijving' => $_POST['beschrijving'],
      ':looptijd' => $_POST['looptijd'],
      ':startprijs' => (float)$_POST['startprijs'],
      ':betalingswijze' => $_POST['betalingswijze'],
      ':betalingsinstructie' => $_POST['betalingsinstructie'],
      ':verzendkosten' => (float)$_POST['verzendkosten'],
      ':verzendinstructies' => $_POST['verzendinstructies'],
      ':plaatsnaam' => $plaats[0]['plaatsnaam'],
      ':land' => $plaats[0]['land'],
      ':verkoper' => $_SESSION['gebruikersnaam']
    );
    $uploadFoto = array(
      ':filenaam' => $_POST['uploadfoto'],
      ':voorwerpnummer' => $voorwerpnummerUpload[0]['nieuwVoorwerpnummer']
    );

    handlequery('INSERT INTO Voorwerp (voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
      land, looptijd, looptijdBeginDag, looptijdBeginTijdstip, verzendkosten, verzendinstructies, verkoper, veilingGesloten)
      VALUES (:voorwerpnummer, :titel, :beschrijving, :startprijs, :betalingswijze, :betalingsinstructie, :plaatsnaam, :land, :looptijd,
        GETDATE(), GETDATE(), :verzendkosten, :verzendinstructies, :verkoper, 0)', $uploadItem);
    handlequery('INSERT INTO Bestand (filenaam, voorwerpnummer) VALUES (:filenaam, :voorwerpnummer)', $uploadFoto);

    header("Location: productpage.php?product=" . $voorwerpnummerUpload[0]['nieuwVoorwerpnummer']); // verwijzen naar nieuw
      } else {
        echo '<main><section><div class="container">
        Niet alle velden zijn ingevuld <br><br>
        <form action="upload-article.php" method="get">
        <input type="submit" value="Opnieuw proberen"
        name="Submit" id="frm1_submit"/></div>
        </form>
        </section></main>';
      }
    }
    echo '<main>
      <section class="uploadarticle">
        <div class="container">
          <div class="row">
            <form class="" method="POST">
              <legend>Voorwerp veilen!</legend>
              <p>Velden met een * zijn verplicht</p>
              <div class="form-group">
                <label class="col-md-12 control-label" for="titel">Titel voor veiling*</label>
                <div class="col-md-12">
                  <input id="titel" name="titel" type="text" class="form-control input-md" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="beschrijving">Beschrijving*</label>
                <div class="col-md-12">
                  <textarea class="form-control" id="beschrijving" name="beschrijving" required></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="looptijd">Looptijd in dagen*</label>
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
                <label class="col-md-12 control-label" for="startprijs">Startprijs in euro&apos;s*</label>
                <div class="col-md-5">
                  <input id="startprijs" name="startprijs" type="number" class="form-control input-md" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="betalingswijze">Betalingswijze*</label>
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
                <label class="col-md-12 control-label" for="uploadphoto">Upload foto*</label>
                <div class="col-md-12">
                  <input id="uploadfoto" name="uploadfoto" class="input-file" type="file">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="verzenden"></label>
                <div class="col-md-12">
                  <button id="sellitem" name="sellitem" type="submit" class="cta-orange">Verkopen!</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>

    </main>';
  } else {
    echo '<main><section>
    niet ingelogd > redirect naar?<br>
    nog geen verkoper > redirect naar verkoper worden?
    </section></main>';
  }
    ?>

    <!-- <main>
      <section class='uploadarticle'>
        <div class="container">
          <div class="row">
            <form class="" method="POST">
              <legend>Voorwerp veilen!</legend>
              <p>Velden met een * zijn verplicht</p>
              <div class="form-group">
                <label class="col-md-12 control-label" for="titel">Titel voor veiling*</label>
                <div class="col-md-12">
                  <input id="titel" name="titel" type="text" class="form-control input-md" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="beschrijving">Beschrijving*</label>
                <div class="col-md-12">
                  <textarea class="form-control" id="beschrijving" name="beschrijving" required></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="looptijd">Looptijd in dagen*</label>
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
                <label class="col-md-12 control-label" for="startprijs">Startprijs in euro's*</label>
                <div class="col-md-5">
                  <input id="startprijs" name="startprijs" type="number" class="form-control input-md" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="betalingswijze">Betalingswijze*</label>
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
                <label class="col-md-12 control-label" for="uploadphoto">Upload foto*</label>
                <div class="col-md-12">
                  <input id="uploadfoto" name="uploadfoto" class="input-file" type="file">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-12 control-label" for="verzenden"></label>
                <div class="col-md-12">
                  <button id="sellitem" name="sellitem" type="submit" class="cta-orange">Verkopen!</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </section>

    </main> -->

    <?php require_once 'footer.php' ?>
