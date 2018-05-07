<?php
require_once 'header.php';

$_SESSION["error_registration"] = ' ';
$_SESSION['message_login'] = ' ';
// $_SESSION['code']= ' ';

// de error regisration werkt niet
// als we het wachtwoord willen checken op nummer, dan moeten we javascript gebruiken
?>
<main id="login-registration">

    <div class="container">
        <div class="row row-left">
            <?php
                echo '<p>'.$_SESSION['error_registration'].'</p>';

                if($_SERVER['REQUEST_URI'] == '/I-Project/user.php' || $_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=1') {
                    require_once 'form-step-1.php';
                } else if($_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=2') {
                    require_once 'form-step-2.php';
                } else if($_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=3') {
                    require_once 'form-step-3.php';
                } else if($_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=4') {
                    require_once 'form-step-4.php';
                }
            ?>
        </div>

        <div class="row row-right">
            <?php
                echo '<p>'.$_SESSION['message_login'].'</p>';

                require_once './form-login.php';
            ?>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


