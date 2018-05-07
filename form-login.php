<?php
echo('
<form method="post">
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
');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login-submit'])) {
    	session_start();
        $_SESSION['email-login'] = $_POST['email-login'];
        $_SESSION['wachtwoord'] = $_POST['wachtwoord'];
        echo '<script> location.replace("./login.php"); </script>';
    }
}
?>