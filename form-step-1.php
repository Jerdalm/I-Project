<?php
require_once './head.php';
require_once './db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	if (checkIfFieldsFilledIn($_POST)) {
	    $_SESSION['email-registration'] = $_POST['email'];      
	    sendRegistrationCode(($_POST['email']));
	} else {
		$_SESSION['error-registration'] = 'U heeft het veld nog niet ingevuld';
	}
}

echo '
<form method="post">
    <div class="form-group">
        <label for="inputEmail"> e-mail </label>
        <input type="textarea" class="form-control" name="email" id="registration-email">
    </div>

    <button type="submit" name="submit-mail" value="send-code" class="btn btn-primary btn-sm">Code sturen</button>
</form>
';

?>