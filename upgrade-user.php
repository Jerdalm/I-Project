<?php
require_once 'header.php';

$_SESSION['error_upgrade'] = '';

<<<<<<< HEAD
$_SESSION['gebruikersnaam'] = 'testnaam'; // voor testdoeleinde wordt gebruikersnaam automatisch testnaam deze regel kan weg na het testen
=======
$_SESSION['gebruikersnaam'] = 'admin'; // voor testen wordt gebruikersnaam automatisch testnaam deze regel kan weg na het testen
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
$_SESSION['email-upgradeDB'] = handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam",array(':gebruikersnaam' => $_SESSION['gebruikersnaam']));
$_SESSION['email-upgrade'] = $_SESSION['email-upgradeDB'][0]['mailadres'];

?>
<main id="upgrade-user">
<<<<<<< HEAD
  <section class="upgrade">
=======
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
    <div class="container">
        <div class="row row-left">
            <?php

<<<<<<< HEAD
            echo '<p>'.$_SESSION['error_upgrade'].'</p>';

            if($_SERVER['REQUEST_URI'] == '/upgrade-user.php' || $_SERVER['REQUEST_URI'] == '/user.php?step=1') {
                require_once 'upgrade-step-1.php';
            } elseif ($_SERVER['REQUEST_URI'] == '/upgrade-user.php?step=2') {
=======
            if($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php' || $_SERVER['REQUEST_URI'] == 'user.php?step=1') {
                require_once 'upgrade-step-1.php';
            } elseif ($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php?step=2') {
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
                require_once 'upgrade-step-2.php';
            }
            ?>
        </div>
<<<<<<< HEAD
    </div>
  </section>
</main>
<?php require_once 'footer.php' ?>
=======

        <?php
        if (isset($message_upgrade)) { // het tonen van een error bericht boven de pagina
            echo '<p class="error error-warning">' . $message_upgrade . '</p>';
        }
        ?>
    </div>
</main>

<?php
require_once 'footer.php';
?>



>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
