<?php
require_once './head.php';
require_once './db.php';

$bankField = array('bank');
$banknumberField = array('banknumber');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(checkIfFieldsFilledIn($bankField)) {
        $_SESSION['bank'] = $_POST['bank'];
    }
    if(checkIfFieldsFilledIn($banknumberField)) {
        $_SESSION['banknumber'] = $_POST['banknumber'];
    }

    $_SESSION['verificationMethod'] = $_POST['verificationMethod'];
    $verificationMethod = $_POST['verificationMethod'];
    header("Location: ./upgrade-user.php?step=2");
}

echo '
<form method="post">
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
            <option value="credit card">creditcard</option>
            <option value="post">post</option>
        </select>
    </div>
    <button type="submit" name="submit-upgrade" class="btn btn-primary btn-sm"> doorgaan </button>
</form> 
';

?>