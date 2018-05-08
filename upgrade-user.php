<?php
require_once 'header.php';

$_SESSION['error_upgrade'] = '';
//$_SESSION['email-upgrade'] = handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam",array(':gebruikersnaam' => $SESSION['username']));
$_SESSION['email-upgrade'] = handleQuery("SELECT * FROM Gebruiker WHERE gebruikersnaam = :gebruikersnaam",array(':gebruikersnaam' => 'testnaam'));
//var_dump($_SESSION['email-upgrade'][0]['mailadres']);

?>
<main id="upgrade-user">

    <div class="container">
        <div class="row row-left">
            <?php

            echo '<p>'.$_SESSION['error_upgrade'].'</p>';

            if($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php' || $_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=1') {
                require_once 'upgrade-step-1.php';
            } elseif ($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php?step=2') {
                require_once 'upgrade-step-2.php';
            }
            ?>
        </div>
    </div>
</main>



