<?php
require_once './db.php';


if (isset($_POST['submit-code-registration'])){

	if (checkIfFieldsFilledIn()) {
<<<<<<< HEAD
       $_SESSION['hashedcode'] = md5($_POST['code']);
       if (validateCode($_POST['code'], $_SESSION['email-registration'])){
           header("Location: ./user.php?step=3");
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
</form>
';
?>
=======
		$_SESSION['hashedcode'] = md5($_POST['code']);
		if (validateCode($_POST['code'], $_SESSION['email-registration'])){
			header("Location: ./registreren.php?step=3");
		} else {
			$message_registration = 'De code komt niet overeen.';
		}
	} else {
		$message_registration = 'U heeft het veld nog niet ingevuld.';
	}
}
?>

<form method="post" class="form-steps">
	<div class="form-group">
		<label for="code">uw code</label>
		<input type="textarea" class="form-control" name="code" id="code">
	</div>

	<button type="submit" name="submit-code-registration" value="Register" class="btn btn-primary btn-sm">Code invoeren</button>
</form>
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
