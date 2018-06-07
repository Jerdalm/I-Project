<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login-submit'])) {
        $_SESSION['email-login'] = $_POST['email-login'];
        $_SESSION['wachtwoord'] = $_POST['wachtwoord'];
        $message_login = loginControl($_POST['email-login'], $_POST['wachtwoord']);
        loginControl($_POST['email-login'], $_POST['wachtwoord']);
    }
}

echo '
<form method="post" id="login-form">
    <div class="form-group">
        <label for="inputEmail">Email of Gebruikersnaam</label>
        <input type="text" class="form-control" id="email-login" name="email-login">
    </div>
    <div class="form-group">
        <label for="inputPassword">Wachtwoord</label>
        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord">
    </div>
    <a href= "wachtwoord-vergeten.php"> Wachtwoord Vergeten? </a><br><br>
    <button type="submit" name="login-submit" class="btn btn-primary">Login</button>
</form>
';
?>