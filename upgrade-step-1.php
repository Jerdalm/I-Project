<?php
require_once './head.php';
require_once './db.php';
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

    if($_POST['verificationMethod'] == '4') {
        if($_SESSION['banknumber'] == NULL || ($_SESSION['bank'] == NULL)) {
            $_SESSION["error_upgrade"] = 'bank en rekeningnummer moeten worden ingevoerd als u voor de post verificatie kiest';
            header("Location: ./upgrade-user.php");
        } else {
            $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
            header("Location: ./upgrade-user.php?step=2");
        }
    }

    if($_POST['verificationMethod'] == '5') {
        $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
        sendUpgradeCode($email);
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
    <div class="form-group">
        <select name="verificationMethod" class="form-control">
            <option value="5">creditcard</option>
            <option value="4">post</option>
        </select>
    </div>
    <button type="submit" name="submit-upgrade" class="btn btn-primary btn-sm"> doorgaan </button>
</form> 
';

?>