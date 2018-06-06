<?php
require_once './db.php';


if (isset($_POST['submit-code-registration'])){

	if (checkIfFieldsFilledIn()) {
       $_SESSION['hashedcode'] = $_POST['code'];
       if (validateCode($_POST['code'], $_SESSION['email-registration'])){
           redirectJS("./registreren.php?step=3");
       } else {
           $message_registration = 'De code komt niet overeen.';
       }
   } else {
       $message_registration = 'U heeft het veld nog niet ingevuld.';
   }
}

echo '
<form method="post" class="form-steps">
<div class="form-group">
<label for="code">uw code</label>
<input type="textarea" class="form-control" name="code" id="code">
</div>

<button type="submit" name="submit-code-registration" value="Register" class="btn btn-primary btn-sm">Code invoeren</button>
<br><br>
Geen code ontvangen? Geen paniek. Het kan tot tien minuten duren voor u de code ontvangt.
</form>
';
?>
