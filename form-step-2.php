<?php
require_once './db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	if(checkIfFieldsFilledIn($_POST)){   	    	
    	$_SESSION['hashedcode'] = md5($_POST['code']);
        validateCode($_POST['code'], $_SESSION['email-registration']);
    }
}

echo '
<form method="post">
    <div class="form-group">
        <label for="code">uw code</label>
        <input type="textarea" class="form-control" name="code" id="id1">
    </div>

     <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
</form>
';
?>