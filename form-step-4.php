<?php
require_once './db.php';


$required = array('firstname', 'lastname', 'adres1', 'postalcode', 'residence', 'country', 'phonenumber', 'birthdate', 'secretanswer'); 
$fields = array('firstname', 'lastname', 'adres1', 'adres2', 'postalcode', 'residence', 'country', 'phonenumber', 'birthdate', 'secretquestion', 'secretanswer');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {     
    if (checkIfFieldsFilledIn($required)) {
        insertRegistrationnfoInDB();
    } else {
        $_SESSION['error_registration'] = "gebruikersnaam of wachtwoord is niet ingevoerd";
    }
}

echo '

<form method ="post">
    <div class="form-group">
        <label for="firstname">Voornaam</label>
        <input type="text" class="form-control" name="firstname" id="firstname" required>
    </div>
    <div class="form-group">
        <label for="lastname">Achternaam</label>
        <input type="text" class="form-control" name="lastname" id="lastname" required>
    </div>
    <div class="form-group">
        <label for="adres1">Adresregel 1</label>
        <input type="text" class="form-control" name="adres1" id="adres1" required>
    </div>
    <div class="form-group">
        <label for="adres1">Adresregel 2</label>
        <input type="text" class="form-control" name="adres2" id="adres1">
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
            <option value="1">In welke straat ben je geboren?</option>
            <option value="2">Wat is de meisjesnaam van je moeder?</option>
            <option value="3">Wat is je lievelingsgerecht?</option>
            <option value="4">Hoe heet je oudste zus?</option>
            <option value="5">Hoe heet je huisdier?</option>
        </select>
    </div>
    <div class="form-group">
        <label for="secretanswer">Geheim antwoord</label>
        <input type="text" class="form-control" name="secretanswer" id="secretanswer" required>
    </div>

    <button type="submit" name="registratie" class="btn btn-primary btn-sm">Registreren</button>
</form>
';