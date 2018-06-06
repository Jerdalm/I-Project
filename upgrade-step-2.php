<?php
require_once './head.php';
require_once './db.php';

$state = false; // boolean voor debuggen van de header in de insertUpgradeinfoInDb

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_SESSION['verificationMethod'] == 'Post') {
        if (!empty($_POST['creditcardnumber'])) {
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
        } else {
            $_SESSION['creditcardnumber'] = NULL;
        }

        if (!empty($_POST['upgradeCode'])) {

            $_SESSION['upgradeCode'] = $_POST['upgradeCode'];

            if (validateCode($_SESSION['upgradeCode'], $_SESSION['email-upgrade'])) {
                $validateCodeCorrect = true;
                $message_upgrade = '';
                insertUpgradeinfoInDB();
            } else {
                $message_upgrade = 'Code komt niet overeen met de toegestuurde code';
            }
        } else {
            $message_upgrade = 'Code niet ingevoerd';
        }
    }

    if($_SESSION['verificationMethod'] == 'Credit Card') {
        if (isset($_POST['creditcardnumber']) && !empty($_POST['creditcardnumber']) ) {
            $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
            insertUpgradeinfoInDB();
        } else {
        $message_upgrade = 'Creditcardnummer niet ingevoerd';
        }
    }
}

if($_SESSION['verificationMethod'] == 'Post') {
    echo '
    <form class="col-lg-6" style="margin-right:350px;" method="post">
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
    <form class="col-lg-6" method="post">
        <div class="form-group">
            <label for="Creditcardnumber"> creditcardnummer </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="Creditcardnumber">
        </div>


         <button type="submit" name="creditcardnumber-button" class="btn btn-primary btn-sm">Doorgaan</button>
    </form>
';
}
?>
