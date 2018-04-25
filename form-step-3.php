<?php
<form method="post" action="nameAndPasswordCheck.php">
    <div class="form-group">
        <label for="id1"> gebruikersnaam </label>
        <input type="textarea" class="form-control" name="name" id=id1>
    </div>
    <div class="form-group">
        <label for="id2"> wachtwoord </label>
        <input type="password" class="form-control" name="password" id=id2>
    </div>

    <button type="submit" name="submitNaam" class="btn btn-primary btn-sm">Verzenden</button>
</form>
?>