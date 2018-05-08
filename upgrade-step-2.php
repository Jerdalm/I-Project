<?php
require_once './head.php';
require_once './db.php';
// op regel 15 moet insertupgradeinfoindb in de functie validatecode worden gezet, zo word eerste de code gecheckt en dan wordt de data in de database gezet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_SESSION['verificationMethod'] == '4') {
        if (isset($_POST['creditcardnumber'])) {
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
        } else {
            $_SESSION['creditcardnumber'] = NULL;
        }

        if (isset($_POST['upgradeCode'])) {
            $_SESSION['upgradeCode'] = $_POST['upgradeCode'];
            validateCode($_POST['upgradeCode'], $_SESSION['email-registration']);
            insertUpgradeinfoInDB();
        } else {
            $_SESSION["error_upgrade"] = 'upgradeCode niet ingevoerd';
            header("Location: ./upgrade-user.php?step=2");
        }
    }

    if($_SESSION['verificationMethod'] == '5') {
        if (isset($_POST['creditcardnumber'])) {
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
            insertUpgradeinfoInDB();
        }
    } else {
        $_SESSION["error_upgrade"] = 'creditcardnummer niet ingevoerd';
        header("Location: ./upgrade-user.php?step=2");
    }
}



if($_SESSION['verificationMethod'] == '4') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="upgrade-code">uw code</label>
            <input type="textarea" class="form-control" name="upgradeCode" id="upgrade-code">
        </div>
        
        <div class="form-group">
            <label for="Creditcardnumber"> creditcardnummer (optioneel) </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>
    
         <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
    </form>
';
} elseif($_SESSION['verificationMethod'] == '5') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="Creditcardnumber"> creditcardnummer </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>
        
    
         <button type="submit" name="creditcardnumber-button" class="btn btn-primary btn-sm">doorgaan</button>
    </form>
';
}
?>