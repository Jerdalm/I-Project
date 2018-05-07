<?php
require_once './head.php';
require_once './db.php';

$verificationMethod = $_POST['verificationMethod'];

if($verificationMethod == 'post') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="code">uw code</label>
            <input type="textarea" class="form-control" name="code" id="id1">
        </div>
    
         <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
    </form>
';
} elseif($verificationMethod == 'creditcard') {
    echo '
    <form method="post">
        <div class="form-group">
            <label for="Creditcardnumber"> creditcardnummer </label>
            <input type="textarea" class="form-control" name="creditcardnumber" id="id1">
        </div>
    
         <button type="submit" name="creditcardnumber-button" class="btn btn-primary btn-sm">doorgaan</button>
    </form>
';
}
?>