<?php

echo('
<form method="POST">
    <div class=""form-group>
        <label for="inputEmail"> e-mail </label>
        <input type="textarea" class="form-control" name="email" id="id1">
    </div>

    <button type="submit" name="mail" class="btn btn-primary btn-sm">Code sturen</button>
</form>
');

if (isset($_POST['mail'])) {
    $_SESSION['email'] = $_POST['email'];
    $_SESSION["step1"] = false;
    $_SESSION["step2"] = true;

    header("location: ./mail-check.php");
}

?>