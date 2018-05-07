<?php
require_once './db.php';

$_SESSION['message_login'] = ' ';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
    if (checkIfFieldsFilledIn()) {
        
        $_SESSION['username'] = $_POST['username']; 
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['password-repeat'] = $_POST['password-repeat'];
        checkUsernamePassword($_POST['username'], $_POST['password'], $_POST['password-repeat']);        
    } else {
        
        $_SESSION['error_registration'] = "Gebruikersnaam of wachtwoord is niet ingevoerd";
    }
}

echo '
<form method="post">
    <div class="form-group">
        <label for="id1"> Gebruikersnaam </label>
        <input type="textarea" class="form-control" name="username" id=id1>
    </div>
    <div class="form-group">
        <label for="id2"> Wachtwoord </label>
        <input type="password" class="form-control" name="password" id=id2>
    </div>
    <div class="form-group">
        <label for="id2"> Herhaal wachtwoord </label>
        <input type="password" class="form-control" name="password-repeat" id=id2>
    </div>

    <button type="submit" name="submit-naam" value="Register" class="btn btn-primary btn-sm">Verzenden</button>
</form>
';
?>