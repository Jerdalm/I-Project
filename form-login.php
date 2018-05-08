<?php
// session_stop();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login-submit'])) {
    	session_start();
        $_SESSION['email-login'] = $_POST['email-login'];
        $_SESSION['wachtwoord'] = $_POST['wachtwoord'];
        loginControl($_POST['email-login'], $_POST['wachtwoord']);
    }
}

echo '
<form method="post" id="login-form">
    <div class="form-group">
        <label for="inputEmail">Email</label>
        <input type="email" class="form-control" id="email-login" name="email-login" placeholder="Email">
    </div>
    <div class="form-group">
        <label for="inputPassword">Password</label>
        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord">
    </div>
    <a href= "wachtwoord-vergeten.php"> Wachtwoord Vergeten? </a><br><br>
    <button type="submit" name="login-submit" class="btn btn-primary">Login</button>
</form>
';
?>