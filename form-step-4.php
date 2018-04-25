<?php
<form method ="post" action="registrationInsertInfo.php">
    <div class="form-group">
        <label for="id2"> voornaam </label>
        <input type="text" class="form-control" name="firstname" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> achternaam </label>
        <input type="text" class="form-control" name="lastname" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> adresregel1 </label>
        <input type="text" class="form-control" name="adres1" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> adresregel2 </label>
        <input type="text" class="form-control" name="adres2" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> postcode </label>
        <input type="text" class="form-control" name="postalcode" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> plaats </label>
        <input type="text" class="form-control" name="residence" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> land </label>
        <input type="text" class="form-control" name="country" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> telefoonNr1 </label>
        <input type="text" class="form-control" name="phonenumber" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> telefoonNr2 </label>
        <input type="text" class="form-control" name="telefoonNr2" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> geboortedatum </label>
        <input type="text" class="form-control" name="birthdate" id=id2>
    </div>
    <p> geef een geheime vraag op voor de beveiliging van uw account</p>
    <div class="form-group">
        <select class="form-control">
            <option value="1"> In welke straat ben je geboren? </option>
            <option value="2"> Wat is de meisjesnaam van je moeder? </option>
            <option value="3"> Wat is je lievelingsgerecht? </option>
            <option value="4"> Hoe heet je oudste zus? </option>
            <option value="5"> Hoe heet je huisdier? </option>
        </select>
    </div>
    <div class="form-group">
        <label for="id2"> geheim antwoord </label>
        <input type="text" class="form-control" name="secretanswer" id=id2>
    </div>

    <button type="submit" name="registrate" class="btn btn-primary btn-sm">Registreren</button>
</form>
?>