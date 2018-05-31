<?php
require_once './db.php';
$required = array('firstname', 'lastname', 'adres1', 'postalcode', 'residence', 'country', 'phonenumber', 'birthdate', 'secretanswer');
$questions = handlequery("SELECT vraag FROM vraag");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (fieldsFilledIn($required)){
		insertRegistrationinfoInDB();
		mkdir("uploads/user/".$_SESSION['username']);
		$message_registration = insertRegistrationinfoInDB();
	} else {
		$message_registration = "U moet alle velden invullen.";
	}
}
echo '
<form method ="post" class="form-steps">
<div class="form-group">
<label for="firstname">Voornaam</label>
<input type="text" class="form-control" name="firstname" id="firstname">
</div>
<div class="form-group">
<label for="lastname">Achternaam</label>
<input type="text" class="form-control" name="lastname" id="lastname">
</div>
<div class="form-group">
<label for="adres1">Adresregel 1</label>
<input type="text" class="form-control" name="adres1" id="adres1" required>
</div>
<div class="form-group">
<label for="adres2">Adresregel 2</label>
<input type="text" class="form-control" name="adres2" id="adres2">
</div>
<div class="form-group">
<label for="postalcode">Postcode</label>
<input type="text" class="form-control" name="postalcode" id="postalcode" required>
</div>
<div class="form-group">
<label for="residence">Plaats</label>
<input type="text" class="form-control" name="residence" id="residence" required>
</div>
<div class="form-group">
<label for="country">Land</label>
<input type="text" class="form-control" name="country" id="country" required>
</div>
<div class="form-group">
<label for="phonenumber">Telefoonnummer</label>
<input type="tel" class="form-control" name="phonenumber" id="phonenumber" required>
</div>
<div class="form-group">
<label for="birthdate">Geboortedatum</label>
<input type="date" class="form-control" name="birthdate" id ="birthdate" required>
</div>
<p>Geef een geheime vraag op voor de beveiliging van uw account</p>
<div class="form-group">
<select name ="secretquestion" class="form-control" required>
';
foreach ($questions as $key => $field) {
	echo "<option value=".$key.">".$field['vraag']."</option>";
};
echo'
</select>
</div>
<div class="form-group">
<label for="secretanswer">Geheim antwoord</label>
<input type="text" class="form-control" name="secretanswer" id="secretanswer" required>
</div>

<button type="submit" name="registratie" value="Register" class="btn btn-primary btn-sm">Registreren</button>
</form>
';
