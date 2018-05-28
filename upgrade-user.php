<?php
require_once 'header.php';

$_SESSION['email-upgradeDB'] = handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam",array(':gebruikersnaam' => $_SESSION['gebruikersnaam']));
$_SESSION['email-upgrade'] = $_SESSION['email-upgradeDB'][0]['mailadres'];

?>
<main id="upgrade-user">
  <section class="upgrade">
    <div class="container">
        <div class="row row-left">
            <?php

            if($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php' || $_SERVER['REQUEST_URI'] == '/user.php?step=1') {
                require_once 'upgrade-step-1.php';
            } elseif ($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php?step=2') {
                require_once 'upgrade-step-2.php';
            }

            if (isset($message_upgrade)){
                echo '<p class="error error-warning">' . $message_upgrade . '</p>';
            }

            ?>
        </div>
    </div>
  </section>
</main>
<?php require_once 'footer.php' ?>
