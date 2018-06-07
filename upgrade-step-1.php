<?php
require_once './head.php';
require_once './db.php';

// de code is standaard 222 voor het testen
$randomVerificationCode = generateRandomCode();
$soortCode = 1;
// $randomVerificsendRegistrationCodeationCode = generateRandomCode();

$subjectText = 'Word verkoper!';
$bodyText = '
Beste '.$_SESSION['gebruikersnaam'].', <br><br>
Om verkoper te worden is de volgende persoonlijke verificatiecode nodig: <b>'.$randomVerificationCode.'</br>.
U kunt deze code invullen in het upgrade formulier. Daarna kunt u voorwerpen aanbieden om te veilen!
';

$headerLocationIf ='upgrade-user.php?step=2';
$headerLocationElse ='upgrade-user.php?step=1';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // nadat er op de knop gedrukt wordt
    if(!empty($_POST['bank'])) {
        $_SESSION['bank'] = $_POST['bank'];
    } else {
        $_SESSION['bank'] = NULL;
    }
    if(!empty($_POST['banknumber'])) {
        $_SESSION['banknumber'] = $_POST['banknumber'];
    } else {
        $_SESSION['banknumber'] = NULL;
    }

    if($_POST['verificationMethod'] == 'Post') { // is er gekozen voor de post
        if($_SESSION['banknumber'] == NULL || ($_SESSION['bank'] == NULL)) {
            $message_upgrade = 'bank en rekeningnummer moeten worden ingevoerd als u voor de post verificatie kiest';
        } else {
            $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
            $message_upgrade = '';
            sendCode($_SESSION['email-upgrade'], $subjectText, $bodyText, $headerLocationIf, $headerLocationElse, $randomVerificationCode,$soortCode);
        }
    }

    if($_POST['verificationMethod'] == 'Credit Card') { // is er gekozen voor de creditcard
        $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
        $message_upgrade = '';
        redirectJS("./upgrade-user.php?step=2");
    }
}

echo '
<form class="col-lg-6" method="post" >
    <div class="form-group">
        <label for="input-bank"> Bank </label>
        <input type="textarea" class="form-control" name="bank" id="user-bank">
    </div>


    <div class="form-group">
        <label for="input-banknumber"> Rekeningnummer </label>
        <input type="textarea" class="form-control" name="banknumber" id="user-banknumber">
    </div>

    <p>Verificatie methode</p>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="verificationMethod" id="verificationMethodSelect1" value="Credit Card" checked>
        <label class="form-check-label" for="verificationMethodSelect1">
            Creditcard
        </label>
    </div>
    <br>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="verificationMethod" id="verificationMethodSelect2" value="Post">
        <label class="form-check-label" for="verificationMethodSelect2">
            Post
        </label>
    </div>
    <br>
    <button type="submit" name="submit-upgrade" class="btn btn-primary btn-sm"> Doorgaan </button>
</form>
';

?>
