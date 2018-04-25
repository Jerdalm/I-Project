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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['mail'])) {
        $_SESSION['email'] = $_POST['email'];
        header("location: ./mail-check.php");
    }
}

?>