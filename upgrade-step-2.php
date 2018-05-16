<?php
require_once './head.php';
require_once './db.php';

// na het upgraden van de gebruiker wordt de gebruiker niet doorgestuurd als er voor post gekozen is
// hij wordt wel doorgestuurd als de gebruiker voor credit card kiest

$state = false; // boolean voor debuggen van de header in de insertUpgradeinfoInDb

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_SESSION['verificationMethod'] == 'Post') {
        if (isset($_POST['creditcardnumber'])) {
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
=======
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // is er op de knop gedrukt
    if ($_SESSION['verificationMethod'] == 'Post') { // is de validatie methode post
        if (isset($_POST['creditcardnumber'])) { // als het creditcardnummer is ingevoert sla het op in een variabele,
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber']; // anders sla NULL op
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
        } else {
            $_SESSION['creditcardnumber'] = NULL;
        }

<<<<<<< HEAD
        if (isset($_POST['upgradeCode'])) {

            $_SESSION['upgradeCode'] = $_POST['upgradeCode'];

            if (validateCode($_SESSION['upgradeCode'], $_SESSION['email-upgrade'])) {
                $validateCodeCorrect = true;
                insertUpgradeinfoInDB();
            } else {
                $_SESSION["error_upgrade"] = 'upgradeCode komt niet overeen met de toegestuurde code';
                header("Location: ./upgrade-user.php?step=2");
            }
        } else {
            $_SESSION["error_upgrade"] = 'upgradeCode niet ingevoerd';
            header("Location: ./upgrade-user.php?step=2");
        }
    }

    if($_SESSION['verificationMethod'] == 'Credit Card') {
        if (isset($_POST['creditcardnumber'])) {
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
            insertUpgradeinfoInDB();
            header("Location: /user-details.php");
        		exit();
        }
    } else {
        $_SESSION["error_upgrade"] = 'creditcardnummer niet ingevoerd';
        header("Location: ./upgrade-user.php?step=2");
=======
        if (isset($_POST['upgradeCode'])) { // is de upgrade code ingevoerd

            $_SESSION['upgradeCode'] = $_POST['upgradeCode']; // sla de ingevoerde code op in een variabele

            if (validateCode($_SESSION['upgradeCode'], $_SESSION['email-upgrade'])) { // is de ingevoerde code correct voer dan alle gegevens in in de database
                $validateCodeCorrect = true;
                insertUpgradeinfoInDB();
            } else {
                $message_upgrade = 'upgradeCode komt niet overeen met de gemailde code';
            }
        } else {
            $message_upgrade = 'upgradeCode niet ingevoerd';
        }
    }

    if ($_SESSION['verificationMethod'] == 'Credit Card') { // is de validatie methode credit card
        if (isset($_POST['creditcardnumber'])) { // is het creditcardnummer ingevoerd
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber']; // sla het nummer op in een variabele en voer alle gegevens in in de database
            insertUpgradeinfoInDB();
        } else {
            $message_upgrade = 'creditcardnummer niet ingevoerd';
            header("Location: upgrade-user.php?step=2");
        }
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
    }
}

if($_SESSION['verificationMethod'] == 'Post') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="upgrade-code">Uw code</label>
            <input type="textarea" class="form-control" name="upgradeCode" id="upgrade-code">
        </div>
<<<<<<< HEAD

=======
        
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
        <div class="form-group">
            <label for="Creditcardnumber"> Creditcardnummer (optioneel) </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>
<<<<<<< HEAD

=======
    
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
         <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
    </form>
';
} elseif($_SESSION['verificationMethod'] == 'Credit Card') {
    echo '
    <form method="post">
        <div class="form-group">
<<<<<<< HEAD
            <label for="Creditcardnumber"> creditcardnummer </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>


=======
            <label for="Creditcardnumber"> Creditcardnummer </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>
        
    
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
         <button type="submit" name="creditcardnumber-button" class="btn btn-primary btn-sm">Doorgaan</button>
    </form>
';
}
<<<<<<< HEAD
?>
=======
?>
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
