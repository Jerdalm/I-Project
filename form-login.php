<?php
$t=time();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login-submit'])) {
        if(($t - $_SESSION['fifthloginattempt_time']) > 30 && $_SESSION['fifthloginattempt_time'] != 0 ) {
            $_SESSION['login-attempts'] = 0;
        }

        if ($_SESSION['login-attempts'] < 4) {

                $_SESSION['email-login'] = $_POST['email-login'];
                $_SESSION['wachtwoord'] = $_POST['wachtwoord'];
                $message_login = loginControl($_POST['email-login'], $_POST['wachtwoord']);
                loginControl($_POST['email-login'], $_POST['wachtwoord']);

                $_SESSION['fifthloginattempt_time'] = 0;
                $_SESSION['login-attempts']++;

        } else {
            $_SESSION['fifthloginattempt_time'] = $t;
            $message_login = "E-mail of wachtwoord is 5 keer verkeerd ingevoerd, wacht 30sec voordat u opnieuw iets invoerd";
        }
    }
} ?>

<div class="col-md-4">
    <div class="card">
        <article class="card-body">
            <a href="./registreren.php" class="float-right btn btn-outline-primary">Registreer nu!</a>
            <h4 class="card-title mb-4 mt-1">INLOGGEN</h4>
            <?php if (isset($message_login)){
                echo '<p class="error error-warning">' . $message_login . '</p>';
            }?>
            <form method="post">
                <div class="form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                        <input class="form-control" placeholder="Email of gebruikersnaam" type="text"  id="email-login" name="email-login">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                        <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="******">
                    </div>
                </div> 
                <div class="form-group">
                    <button type="submit" name="login-submit" class="btn btn-primary btn-block"> Login </button>
                    <p class="text-center">
                        <a class="btn" href="./wachtwoord-vergeten.php">Vergeten?</a>
                    </p>
                </div>                                                          
            </form>
        </article>
    </div>
</div>