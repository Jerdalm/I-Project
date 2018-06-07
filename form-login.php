<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login-submit'])) {
        $_SESSION['email-login'] = $_POST['email-login'];
        $_SESSION['wachtwoord'] = $_POST['wachtwoord'];
        $message_login = loginControl($_POST['email-login'], $_POST['wachtwoord']);
        loginControl($_POST['email-login'], $_POST['wachtwoord']);
    }
}
?>

<div class="col-md-4">
    <div class="card">
        <article class="card-body">
            <a href="./registreren.php" class="float-right btn btn-outline-primary">Registreer nu!</a>
            <h4 class="card-title mb-4 mt-1">Sign in</h4>
            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input class="form-control" placeholder="Email" type="email"  id="email-login" name="email-login">
                </div>
                <div class="form-group">
                    <a class="float-right" href="./wachtwoord-vergeten.php">Vergeten?</a>
                    <label>Wachtwoord</label>
                    <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="******">
                </div> 
                    <div class="form-group">
                    <button type="submit" name="login-submit" class="btn btn-primary btn-block"> Login </button>
                </div>                                                          
            </form>
        </article>
    </div>
</div>