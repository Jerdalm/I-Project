<?php
echo('
<form method="post">
    <div class=""form-group>
        <label for="inputCode">uw code</label>
        <input type="textarea" class="form-control" name="code" id="id1">
    </div>

     <button type="submit" name="code-button" class="btn btn-primary btn-sm">Code invoeren</button>
</form>
');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['code-button'])) {
        $_SESSION['code'] = $_POST['code'];
        header("location: ./code-check.php");
    }
}
?>