<?php
require_once './head.php';
require_once './db.php';
$randomVerificationCode = 111111;
// $randomVerificsendRegistrationCodeationCode = generateRandomCode();
$subjectText = 'upgraden account';
$bodyText = '
Beste gebruiker,

Hier is uw verificatiecode voor het upgraden van uw account naar verkoper

'.$randomVerificationCode. '

U kunt deze code invullen in het upgrade formulier.
';

$headerLocationIf ='upgrade-user.php?step=2';
$headerLocationElse ='upgrade-user.php?step=1';

$email = $_SESSION['email-upgrade'][0]['mailadres'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['bank'])) {
        $_SESSION['bank'] = $_POST['bank'];
    } else {
        $_SESSION['bank'] = NULL;
    }
    if(isset($_POST['banknumber'])) {
        $_SESSION['banknumber'] = $_POST['banknumber'];
    } else {
        $_SESSION['banknumber'] = NULL;
    }

    if($_POST['verificationMethod'] == '4') { // is er gekozen voor de post
        if($_SESSION['banknumber'] == NULL || ($_SESSION['bank'] == NULL)) {
            $_SESSION["error_upgrade"] = 'bank en rekeningnummer moeten worden ingevoerd als u voor de post verificatie kiest';
            header("Location: ./upgrade-user.php");
        } else {
            $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
            sendCode($email, $subjectText, $bodyText, $headerLocationIf, $headerLocationElse);
        }
    }

    if($_POST['verificationMethod'] == '5') { // is er gekozen voor de creditcard
        $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
        header("Location: ./upgrade-user.php?step=2");
    }
}

echo '
<form method="post" >
    <div class="form-group">
        <label for="input-bank"> bank </label>
        <input type="textarea" class="form-control" name="bank" id="user-bank">
    </div>
    
    
    <div class="form-group">
        <label for="input-banknumber"> rekeningnummer </label>
        <input type="textarea" class="form-control" name="banknumber" id="user-banknumber">
    </div>
    
    <p>verificatie methode</p>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="verificationMethod" id="verificationMethodSelect1" value="5" checked>
        <label class="form-check-label" for="verificationMethodSelect1">
            creditcard
        </label>
    </div>
    <br>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="verificationMethod" id="verificationMethodSelect2" value="4">
        <label class="form-check-label" for="verificationMethodSelect2">
            post
        </label>
    </div>
<!--
    <div class="form-group">
        <select name="verificationMethod" class="form-control">
           <option value="5">creditcard</option>
           <option value="4">post</option>
        </select>
    </div>
    -->
    <br>
    <button type="submit" name="submit-upgrade" class="btn btn-primary btn-sm"> doorgaan </button>
</form> 
';

?>