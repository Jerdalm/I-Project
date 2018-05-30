<?php require_once 'header.php';

if (isset($_SESSION['gebruikersnaam'])) {
  $username = $_SESSION['gebruikersnaam'];
  if ($_SESSION['soortGebruiker'] != 2) {
    header("Location: upgrade-user.php"); // redirect naar upgrade user wanneer je geen verkoper bent
    die()
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $filledin = array(
    'titel',
    'beschrijving',
    'looptijd',
    'startprijs',
    'betalingswijze'
  );

  if (isset($_POST['sellitem']) && fieldsFilledIn($filledin) && $_FILES["fileToUpload"]["size"] != 0) {
    if (empty($_POST['betalingsinstructie'])) {
      $_POST['betalingsinstructie'] = NULL;
    } if (empty($_POST['verzendkosten'])) {
      $_POST['verzendkosten'] = 0.00;
    } if (empty($_POST['verzendinstructies'])) {
      $_POST['verzendinstructies'] = NULL;
    }

    $voorwerpnummerUpload = handlequery("SELECT dbo.fnc_voorwerpnummer()");

    $plaats = handlequery("SELECT plaatsnaam, land FROM Gebruiker WHERE gebruikersnaam = '".$username."'");
    $uploadItem = array(
      ':voorwerpnummer' => $voorwerpnummerUpload[0][0],
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

    handlequery('INSERT INTO Voorwerp (voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
      land, looptijd, looptijdBeginDag, looptijdBeginTijdstip, verzendkosten, verzendinstructies, verkoper, veilingGesloten)
      VALUES (:voorwerpnummer, :titel, :beschrijving, :startprijs, :betalingswijze, :betalingsinstructie, :plaatsnaam, :land, :looptijd,
      GETDATE(), GETDATE(), :verzendkosten, :verzendinstructies, :verkoper, 0)', $uploadItem);

      $target_dir = "./uploads/" . $username . '/' . $voorwerpnummerUpload[0][0]. '/';
      if (!file_exists($target_dir)){
        mkdir('uploads/'. $username . '/' . $voorwerpnummerUpload[0][0] , 02202, true);
      }

      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      if(checkIfImage($_POST["sellitem"]) && checkAllowedFileTypes($imageFileType) && checkSizeFile(1000000) && checkExistingFile($target_file)) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          $uploadFoto = array(':voorwerpnummer' => $voorwerpnummerUpload[0][0] , ':filenaam' => $target_file);
          handlequery("INSERT INTO Bestand (filenaam, voorwerpnummer) VALUES (:filenaam, :voorwerpnummer)", $uploadFoto);
        }
        else {
          echo "Sorry, Er is iets fout gegaan tijdens het uploaden van uw bestand.";
          die();
        }
      }
    header("Location: productpage.php?product=" . $voorwerpnummerUpload[0][0]); // verwijzen naar nieuw
    die();
      } else {
        echo '<main><section><div class="container">
        Niet alle velden zijn ingevuld <br><br>
        <form action="upload-article.php" method="get">
        <input type="submit" value="Opnieuw proberen"
        name="Submit" id="frm1_submit"/></div>
        </form>
        </section></main>';
        die();
      }
    }
    echo '<main>
      <section class="uploadarticle">
        <div class="container">
          <div class="row">
            <form method="POST" enctype="multipart/form-data">
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
                  <input id="startprijs" name="startprijs" type="number" step="0.01" class="form-control input-md" required>
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
                <label class="col-md-12 control-label" for="fileToUpload">Upload foto*</label>
                <div class="col-md-12">
                  <input id="fileToUpload" name="fileToUpload" class="input-file" type="file" required>
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
    header("Location: index.php"); // redirect naar index wanneer je niet ingelogd bent
    die();
    echo '<main><section>
    niet ingelogd > redirect naar?<br>
    nog geen verkoper > redirect naar verkoper worden?
    </section></main>';
  }

  require_once 'footer.php' ?>
