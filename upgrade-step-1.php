<?php
require_once './head.php';
require_once './db.php';

//if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//    header("Location: ./user.php?step=2");
//}

echo '
<form method="post">
    <div class="form-group">
        <label for="input-bank"> bank </label>
        <input type="textarea" class="form-control" name="bank" id="user-bank">
    </div>
    
    
    <div class="form-group">
        <label for="input-rekeningnummer"> rekeningnummer </label>
        <input type="textarea" class="form-control" name="rekeningnummer" id="user-rekeningnummer">
    </div>
    
    <p>verificatie methode</p>
    <div class="form-group">
            <option value="creditcard">creditcard</option>
            <option value="post">post</option>
        </select>
    </div>
    <button type="submit" name="submit-upgrade" class="btn btn-primary btn-sm"> doorgaan </button>
</form> 
';

?>