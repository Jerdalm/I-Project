<?php
require_once './head.php';
require_once './db.php';

// de code is standaard 222 voor het testen
$randomVerificationCode = 222;
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // nadat er op de knop gedrukt wordt
<<<<<<< HEAD
    if(isset($_POST['bank'])) {
=======
    if(isset($_POST['bank'])) { // als de bank is ingevuld sla die waarde op in een variabele anders sla NULL op
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
        $_SESSION['bank'] = $_POST['bank'];
    } else {
        $_SESSION['bank'] = NULL;
    }
<<<<<<< HEAD
    if(isset($_POST['banknumber'])) {
=======
    if(isset($_POST['banknumber'])) { // als het banknummer is ingevoerd sla die waarde op in een variabele anders sla NULL op
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
        $_SESSION['banknumber'] = $_POST['banknumber'];
    } else {
        $_SESSION['banknumber'] = NULL;
    }

    if($_POST['verificationMethod'] == 'Post') { // is er gekozen voor de post
<<<<<<< HEAD
        if($_SESSION['banknumber'] == NULL || ($_SESSION['bank'] == NULL)) {
            $_SESSION["error_upgrade"] = 'bank en rekeningnummer moeten worden ingevoerd als u voor de post verificatie kiest';
            header("Location: ./upgrade-user.php");
=======
        if($_SESSION['banknumber'] == NULL || ($_SESSION['bank'] == NULL)) { // is banknummer of bank niet ingevoerd schrijf een error en stuur de gebruiker naar stap 1,
            $message_upgrade = 'bank en rekeningnummer moeten worden ingevoerd als u voor de post verificatie kiest'; // anders stuur een mail met de validatiecode

>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
        } else {
            $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
            sendCode($_SESSION['email-upgrade'], $subjectText, $bodyText, $headerLocationIf, $headerLocationElse, $randomVerificationCode);
        }
    }

<<<<<<< HEAD
    if($_POST['verificationMethod'] == 'Credit Card') { // is er gekozen voor de creditcard
        $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
        header("Location: ./upgrade-user.php?step=2");
=======
    if($_POST['verificationMethod'] == 'Credit Card') { // is er gekozen voor de creditcard stuur de gebruiker door naar stap 2
        $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
        header("Location: upgrade-user.php?step=2");
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
    }
}

echo '
<form method="post" >
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
<<<<<<< HEAD

=======
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
?>