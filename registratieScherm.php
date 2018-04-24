<?php include 'head.php';
$stateEmail = 0;
$stateCode = 1;
?>

<?php //require_once 'header.php'; ?>
<main>
    <div class="container">
        <div class="row">
            <form method="post" action="functions/setMail.php">
                <div class=""form-group>
                    <label for="inputEmail"> e-mail </label>
                    <input type="textarea" class="form-control" name="mail" id="id1">
                </div>

                <input type="submit" name="mail" class="btn btn-primary btn-sm"> code sturen </input>
            </form>
            <?php if ($email == 1) {?>

                <form method="post">
                    <div class=""form-group>
                        <label for="inputCode"> uw code </label>
                        <input type="textarea" class="form-control" name="code" id="id1">
                    </div>

                    <button type="submit" name="code" class="btn btn-primary btn-sm"> code invoeren </button>
                </form>
            <?php } ?>

            <?php if ($stateCode == 1) {?>
            <form method="post">
                <div class="form-group">
                    <label for="id1"> gebruikersnaam </label>
                    <input type="textarea" class="form-control" name="naam" id=id1>
                </div>
                <div class="form-group">
                    <label for="id2"> wachtwoord </label>
                    <input type="password" class="form-control" name="wachtwoord" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> voornaam </label>
                    <input type="text" class="form-control" name="voornaam" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> achternaam </label>
                    <input type="text" class="form-control" name="achternaam" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> adres </label>
                    <input type="text" class="form-control" name="adres" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> postcode </label>
                    <input type="text" class="form-control" name="postcode" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> plaats </label>
                    <input type="text" class="form-control" name="plaats" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> land </label>
                    <input type="text" class="form-control" name="land" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> telefoonNr1 </label>
                    <input type="text" class="form-control" name="telefoonNr1" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> telefoonNr2 </label>
                    <input type="text" class="form-control" name="telefoonNr2" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> geboortedatum </label>
                    <input type="text" class="form-control" name="geboortedatum" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> geheime vraag </label>
                    <input type="text" class="form-control" name="geheime vraag" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> geheim antwoord </label>
                    <input type="text" class="form-control" name="geheim antwoord" id=id2>
                </div>

                <button type="submit" class="btn btn-primary btn-sm"> registreren </button>
            </form>

            <?php } ?>

        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


