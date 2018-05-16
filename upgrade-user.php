<?php
require_once 'header.php';

$_SESSION['error_upgrade'] = '';

$_SESSION['gebruikersnaam'] = 'testnaam'; // voor testdoeleinde wordt gebruikersnaam automatisch testnaam deze regel kan weg na het testen
$_SESSION['email-upgradeDB'] = handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam",array(':gebruikersnaam' => $_SESSION['gebruikersnaam']));
$_SESSION['email-upgrade'] = $_SESSION['email-upgradeDB'][0]['mailadres'];

?>
<main id="upgrade-user">
  <section class="upgrade">
    <div class="container">
        <div class="row row-left">
            <?php

            echo '<p>'.$_SESSION['error_upgrade'].'</p>';

            if($_SERVER['REQUEST_URI'] == '/upgrade-user.php' || $_SERVER['REQUEST_URI'] == '/user.php?step=1') {
                require_once 'upgrade-step-1.php';
            } elseif ($_SERVER['REQUEST_URI'] == '/upgrade-user.php?step=2') {
                require_once 'upgrade-step-2.php';
            }
            ?>
        </div>
    </div>
  </section>
</main>
<?php require_once 'footer.php' ?>
