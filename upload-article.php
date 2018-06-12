<?php require_once 'header.php';

if (isset($_SESSION['gebruikersnaam'])) {
  $categories = handlequery("SELECT l.rubrieknummer, r.rubrieknaam AS 'hoofd', l.rubrieknaam AS 'laag' FROM laagsteRubrieken l JOIN Rubriek r ON r.rubrieknummer = l.hoofdrubriek ORDER BY r.rubrieknaam, l.rubrieknaam");
  $username = $_SESSION['gebruikersnaam'];
  if ($_SESSION['soortGebruiker'] != 2) {
    redirectJS("upgrade-user.php"); // redirect naar upgrade user wanneer je geen verkoper bent
    die();
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
      $uploadRubriek = array(
        ':voorwerpnummer' => $voorwerpnummerUpload[0][0],
        ':rubriek' => $_POST['categorie']
      );

      $target_dir = "./uploads/" . $username . '/' . $voorwerpnummerUpload[0][0]. '/';
      if (!file_exists($target_dir)){
        mkdir('uploads/'. $username . '/' . $voorwerpnummerUpload[0][0] , 02202, true);
      }

      $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

      if (checkExistingFile($target_file)) {
        if(checkAllowedFileTypes($imageFileType)){
          if (checkSizeFile(5242880)) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
              $uploadFoto = array(':voorwerpnummer' => $voorwerpnummerUpload[0][0] , ':filenaam' => $target_file);
              handlequery('INSERT INTO Voorwerp (voorwerpnummer, titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, plaatsnaam,
                land, looptijd, looptijdBeginDag, looptijdBeginTijdstip, verzendkosten, verzendinstructies, verkoper, veilingGesloten)
                VALUES (:voorwerpnummer, :titel, :beschrijving, :startprijs, :betalingswijze, :betalingsinstructie, :plaatsnaam, :land, :looptijd,
                GETDATE(), GETDATE(), :verzendkosten, :verzendinstructies, :verkoper, 0)', $uploadItem);
              handlequery('INSERT INTO VoorwerpInRubriek VALUES (:voorwerpnummer, :rubriek)', $uploadRubriek);
              handlequery("INSERT INTO Bestand (filenaam, voorwerpnummer) VALUES (:filenaam, :voorwerpnummer)", $uploadFoto);
              redirectJS("productpage.php?product=" . $voorwerpnummerUpload[0][0]); // verwijzen naar nieuw
            } else {
              $errorUploadArticle = "Sorry, Er is iets fout gegaan tijdens het uploaden van uw bestand.";
            }
          } else {
            $errorUploadArticle = "Sorry, Het bestand is te groot.";
          } 
        } else {
          $errorUploadArticle = "Sorry, De bestandtype klopt niet.";
        }
      } else {
        $errorUploadArticle = "Het bestand bestaat al, kies een andere!";
      }  
    } else {
      $errorUploadArticle = "Sorry, niet alle velden zijn ingevuld.";
    }
  } ?>
  <style>

</style>
<main>
  <section class="uploadarticle">
    <div class="container">
      <form method="POST" enctype="multipart/form-data">
        <legend>Voorwerp veilen!</legend>
        <p>Velden met een * zijn verplicht</p>
        <div class="form-row">
          <div class="form-group col-md-8">
            <label class="control-label" for="titel">Titel voor veiling*</label>
            <input id="titel" name="titel" type="text" class="form-control input-md" required>
          </div>
          <div class="form-group col-md-8">
            <label class="control-label" for="beschrijving">Beschrijving*</label>
            <textarea class="form-control" id="beschrijving" name="beschrijving" required></textarea>
          </div>
          <div class="form-group col-md-8">
            <label class="control-label" for="beschrijving">Categorie*</label>
            <select id="categorie" name="categorie" type="select" class="form-control input-md">
              <?php foreach ($categories as $key => $categorie) {
                echo '<option value=' .$categorie['rubrieknummer'].'>'.$categorie['hoofd'].' / '.$categorie['laag'].'</option>';
              } ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="control-label" for="looptijd">Looptijd in dagen*</label>
            <select id="looptijd" name="looptijd" class="form-control">
              <option value="1">1</option>
              <option value="3">3</option>
              <option value="5">5</option>
              <option value="7">7</option>
              <option value="10">10</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label class="control-label" for="startprijs">Startprijs in euro&apos;s*</label>
            <input id="startprijs" name="startprijs" type="number" min="0" step="0.01" class="form-control input-md" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="control-label" for="betalingswijze">Betalingswijze*</label>
            <select id="betalingswijze" name="betalingswijze" class="form-control">
              <option value="Credit Card">Credit Card</option>
              <option value="iDeal">iDeal</option>
              <option value="PayPal">PayPal</option>
            </select>
          </div>
          <div class="form-group col-md-4">
            <label class="control-label" for="betalingsinstructie">Betalingsinstructie</label>
            <input id="betalingsinstructie" name="betalingsinstructie" type="text" placeholder="Optioneel" class="form-control input-md">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label class="control-label" for="verzendkosten">Verzendkosten</label>
            <input id="verzendkosten" name="verzendkosten" min="0" type="number" placeholder="Optioneel" class="form-control input-md">
          </div>
          <div class="form-group col-md-4">
            <label class="control-label" for="verzendinstructies">Verzendinstructies</label>
            <input id="verzendinstructies" name="verzendinstructies" type="text" placeholder="Optioneel" class="form-control input-md">
          </div>
        </div>
        <div class="form-group col-md-16">
          <p>Upload foto*</p>
          <small>Het bestand moet een .JPG, .JPEG of .PNG zijn.<br>Het bestand mag maximaal 5 MB groot zijn.</small>
          <div class="form-row">
            <div class="custom-file col-md-4" id="customFile">
              <input id="fileToUpload" name="fileToUpload" class="custom-file-input" type="file" required>
              <label class="custom-file-label" for="fileToUpload">Bestand kiezen</label>
            </div>
          </div>
          <?php if (isset($errorUploadArticle)) { echo '<p  class="error error-warning">'.$errorUploadArticle.'</p>';} ?>
          <div class="form-group">
            <label class="control-label" for="verzenden"></label>
            <button id="sellitem" name="sellitem" type="submit" class="cta-orange">Verkopen!</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>;
<script>
  $('.custom-file-input').on('change',function(){
    var fileName = $(this).val();
    if (fileName) {
      var startIndex = (fileName.indexOf('\\') >= 0 ? fileName.lastIndexOf('\\') : fileName.lastIndexOf('/'));
      var filename = fileName.substring(startIndex);
      if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
        filename = filename.substring(1);
      }
      $(this).next('.custom-file-label').addClass("selected").html(filename);
    }
  })
  $(document).ready(function(){
    $('input.typeahead').typeahead({
      name: 'typeahead',
      remote:'search.php?key=%QUERY',
      limit : 10
    });
  });
</script>
<?php  } else {
    redirectJS("index.php"); // redirect naar index wanneer je niet ingelogd bent
  }

  require_once 'footer.php' ?>
