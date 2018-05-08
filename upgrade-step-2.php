<?php
require_once './head.php';
require_once './db.php';

$codeField = array('code');
$creditcardnumberField = array('creditcardnumber');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(checkIfFieldsFilledIn($codeField)) {
        $_SESSION['code'] = $_POST['code'];
    }
    if(checkIfFieldsFilledIn($banknumberField)) {
        $_SESSION['creditcardnumber'] = $_POST['creditcardnumber'];
    }

    insertUpgradeinfoInDB();
}



if($_SESSION['verificationMethod'] == 'post') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="upgrade-code">uw code</label>
            <input type="textarea" class="form-control" name="code" id="upgrade-code">
        </div>
    
         <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
    </form>
';
} elseif($_SESSION['verificationMethod'] == 'creditcard') {
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