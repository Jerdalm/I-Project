<?php
require_once './head.php';
require_once './db.php';

// na het upgraden van de gebruiker wordt de gebruiker niet doorgestuurd als er voor post gekozen is
// hij wordt wel doorgestuurd als de gebruiker voor credit card kiest

$state = false; // boolean voor debuggen van de header in de insertUpgradeinfoInDb

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // is er op de knop gedrukt
    if($_SESSION['verificationMethod'] == 'Post') { // is de validatie methode post
        if (isset($_POST['creditcardnumber'])) { // als het creditcardnummer is ingevoert sla het op in een variabele,
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber']; // anders sla NULL op
        } else {
            $_SESSION['creditcardnumber'] = NULL;
        }

        if (isset($_POST['upgradeCode'])) { // is de upgrade code ingevoerd

            $_SESSION['upgradeCode'] = $_POST['upgradeCode']; // sla de ingevoerde code op in een variabele

            if (validateCode($_SESSION['upgradeCode'], $_SESSION['email-upgrade'])) { // is de ingevoerde code correct voer dan alle gegevens in in de database
                $validateCodeCorrect = true;
                //insertUpgradeinfoInDB();
                header("Location: /I-project/index.php");
                exit();
            } else {
                $_SESSION["error_upgrade"] = 'upgradeCode komt niet overeen met de toegestuurde code';
                header("Location: upgrade-user.php?step=2");
            }
        } else {
            $_SESSION["error_upgrade"] = 'upgradeCode niet ingevoerd';
            header("Location: upgrade-user.php?step=2");
        }
    }

    if($_SESSION['verificationMethod'] == 'Credit Card') { // is de validatie methode credit card
        if (isset($_POST['creditcardnumber'])) { // is het creditcardnummer ingevoerd
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber']; // sla het nummer op in een variabele en voer alle gegevens in in de database
            insertUpgradeinfoInDB();
        }
    } else {
        $_SESSION["error_upgrade"] = 'creditcardnummer niet ingevoerd';
        header("Location: upgrade-user.php?step=2");
    }
}

if($_SESSION['verificationMethod'] == 'Post') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="upgrade-code">Uw code</label>
            <input type="textarea" class="form-control" name="upgradeCode" id="upgrade-code">
        </div>
        
        <div class="form-group">
            <label for="Creditcardnumber"> Creditcardnummer (optioneel) </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>
    
         <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
    </form>
';
} elseif($_SESSION['verificationMethod'] == 'Credit Card') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="Creditcardnumber"> Creditcardnummer </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>
        
    
         <button type="submit" name="creditcardnumber-button" class="btn btn-primary btn-sm">Doorgaan</button>
    </form>
';
}
?>