<?php include 'head.php';
$_SESSION['error_registration'] = '';

?>
<main>

    <div class="container">
        <div class="row">
            <?php if(isset($_POST['mail'])){?>
                <p><?=$_SESSION['error_registration']?></p>
                <form method="post">
                    <div class=""form-group>
                        <label for="inputCode"> uw code </label>
                        <input type="textarea" class="form-control" name="code" id="id1">
                    </div>

                    <button type="submit" name="code" class="btn btn-primary btn-sm"> code invoeren </button>
                </form>
            <?php } elseif(isset($_POST['code'])) { ?>
                <p><?=$_SESSION['error_registration']?></p>
            <form method="post">
                <div class="form-group">
                    <label for="id1"> gebruikersnaam </label>
                    <input type="textarea" class="form-control" name="name" id=id1>
                </div>
                <div class="form-group">
                    <label for="id2"> wachtwoord </label>
                    <input type="password" class="form-control" name="password" id=id2>
                </div>

                <button type="submit" name="submitNaam" class="btn btn-primary btn-sm"> verzenden </button>
            </form>

            <?php } elseif(isset($_POST['submitNaam'])) { ?>
                <p><?=$_SESSION['error_registration']?></p>
            <form method ="post">
                <div class="form-group">
                    <label for="id2"> voornaam </label>
                    <input type="text" class="form-control" name="firstname" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> achternaam </label>
                    <input type="text" class="form-control" name="lastname" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> adres </label>
                    <input type="text" class="form-control" name="adres" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> postcode </label>
                    <input type="text" class="form-control" name="postalcode" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> plaats </label>
                    <input type="text" class="form-control" name="residence" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> land </label>
                    <input type="text" class="form-control" name="country" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> telefoonNr1 </label>
                    <input type="text" class="form-control" name="phonenumber" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> telefoonNr2 </label>
                    <input type="text" class="form-control" name="telefoonNr2" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> geboortedatum </label>
                    <input type="text" class="form-control" name="birthdate" id=id2>
                </div>
                <div class="form-group">
                    <select class="form-control">
                        <option> geheime vraag </option>
                    <input type="text" class="form-control" name="secretquestion" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> geheim antwoord </label>
                    <input type="text" class="form-control" name="secretanswer" id=id2>
                </div>

                <button type="submit" name="registrate" class="btn btn-primary btn-sm"> registreren </button>
            </form>

            <?php } else { ?>
                <p><?=$_SESSION['error_registration']?></p>
            <form method="post">
                <div class=""form-group>
                    <label for="inputEmail"> e-mail </label>
                    <input type="textarea" class="form-control" name="email" id="id1">
                </div>

                <button type="submit" name="mail" class="btn btn-primary btn-sm"> code sturen </button>
            </form>
            <?php } ?>

        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


