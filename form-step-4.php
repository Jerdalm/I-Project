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
        <label for="id2">Voornaam</label>
        <input type="text" class="form-control" name="firstname" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Achternaam</label>
        <input type="text" class="form-control" name="lastname" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Adresregel 1</label>
        <input type="text" class="form-control" name="adres1" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Adresregel 2</label>
        <input type="text" class="form-control" name="adres2" id=id2>
    </div>
    <div class="form-group">
        <label for="id2">Postcode</label>
        <input type="text" class="form-control" name="postalcode" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Plaats</label>
        <input type="text" class="form-control" name="residence" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Land</label>
        <input type="text" class="form-control" name="country" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Telefoonnummer</label>
        <input type="tel" class="form-control" name="phonenumber" id=id2 required>
    </div>
    <div class="form-group">
        <label for="id2">Geboortedatum</label>
        <input type="date" class="form-control" name="birthdate" required>
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
        <label for="id2">Geheim antwoord</label>
        <input type="text" class="form-control" name="secretanswer" id=id2 required>
    </div>

    <button type="submit" name="registratie" class="btn btn-primary btn-sm">Registreren</button>
</form>
';