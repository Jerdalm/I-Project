<?php
require_once './head.php';
require_once './db.php';

if (isset($_POST['submit-mail'])){
	if (checkIfFieldsFilledIn()) {		
	    $_SESSION['email-registration'] = $_POST['email'];      
	    sendRegistrationCode(($_POST['email']));
	} else {
		$message_registration = 'U heeft het veld nog niet ingevuld';

	}
}

echo '
<form method="post" class="form-steps">
    <div class="form-group">
        <label for="inputEmail">E-mail</label>
        <input type="textarea" class="form-control" name="email" id="inputEmail">
    </div>

    <button type="submit" name="submit-mail" value="send-code" class="btn btn-primary btn-sm">Code sturen</button>
</form>
';

?>