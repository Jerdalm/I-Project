<?php
require_once './db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    if (checkIfFieldsFilledIn()) {
        
        $_SESSION['username'] = $_POST['username']; 
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['password-repeat'] = $_POST['password-repeat'];
        checkUsernamePassword($_POST['username'], $_POST['password'], $_POST['password-repeat']);        
    } else {
        
        $message_registration = "Gebruikersnaam of wachtwoord is niet ingevoerd";
    }
}

echo '
<form method="post" class="form-steps">
    <div class="form-group">
        <label for="registration-username"> Gebruikersnaam </label>
        <input type="textarea" class="form-control" name="username" id="registration-username">
    </div>
    <div class="form-group">
        <label for="registration-password"> Wachtwoord </label>
        <input type="password" class="form-control" name="password" id="registration-password">
    </div>
    <div class="form-group">
        <label for="password-repeat"> Herhaal wachtwoord </label>
        <input type="password" class="form-control" name="password-repeat" id="password-repeat">
    </div>

    <button type="submit" name="submit-naam" value="Register" class="btn btn-primary btn-sm">Verzenden</button>
</form>
';
?>