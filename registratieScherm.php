<?php
require_once 'header.php';

$_SESSION["error_registration"] = '';
$_SESSION["submitNaam"] = false;
$_SESSION["mailButton"] = false;

//if ($_SESSION["submitNaam"] == FALSE) {
//    echo "FALSE";
//}
//print_r ($_SESSION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        require_once 'login.php';
    }
}
?>
<main id="login-registration">

    <div class="container">
        <div class="row row-left">
              <p><?=$_SESSION['error_registration']?></p>

            <?php if(isset($_POST['mail'])) { 
            $_SESSION['emailadresControle1'] = ($_POST['email']);
            header("location: ./mail-check.php"); 
            ?>

                <form method="post">
                    <div class=""form-group>
                        <label for="inputCode"> uw code </label>
                        <input type="textarea" class="form-control" name="code" id="id1">
                    </div>

                    <button type="submit" name="code" class="btn btn-primary btn-sm">Code invoeren</button>
                </form>

            <?php } elseif(isset($_POST['code'])) { ?>

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

            <?php } elseif(isset($_POST['submitNaam'])) {
                $_SESSION["submitNaam"] = true;
                header("location: ./nameAndPasswordCheck");
                }
            ?>

            <?php if($_SESSION['submitNaam'] == true) { ?>
            <form method ="post" action="registrationInsertInfo.php">
                <div class="form-group">
                    <label for="id2"> voornaam </label>
                    <input type="text" class="form-control" name="firstname" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> achternaam </label>
                    <input type="text" class="form-control" name="lastname" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> adresregel1 </label>
                    <input type="text" class="form-control" name="adres1" id=id2>
                </div>
                <div class="form-group">
                    <label for="id2"> adresregel2 </label>
                    <input type="text" class="form-control" name="adres2" id=id2>
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
                <p> geef een geheime vraag op voor de beveiliging van uw account</p>
                <div class="form-group">
                    <select class="form-control">
                        <option value="1"> In welke straat ben je geboren? </option>
                        <option value="2"> Wat is de meisjesnaam van je moeder? </option>
                        <option value="3"> Wat is je lievelingsgerecht? </option>
                        <option value="4"> Hoe heet je oudste zus? </option>
                        <option value="5"> Hoe heet je huisdier? </option>
                </div>

                <div class="form-group">
                    <label for="id2"> geheim antwoord </label>
                    <input type="text" class="form-control" name="secretanswer" id=id2>
                </div>

                <button type="submit" name="registrate" class="btn btn-primary btn-sm">Registreren</button>
            </form>

            <?php }
            if ($_SESSION["mailButton"] == false) { ?>

            <form method="POST">
                <div class=""form-group>
                    <label for="inputEmail"> e-mail </label>
                    <input type="textarea" class="form-control" name="email" id="id1">
                </div>

                <button type="submit" name="mail" class="btn btn-primary btn-sm">Code sturen</button>
            </form>

            <?php }
            if(isset($_POST['mail'])) {
                $_SESSION["mailButton"] = true;
                
                $_SESSION["submitButton"] = true;
            }?>

        </div>

        <div class="row row-right">
            <form>
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Password</label>
                    <input type="password" class="form-control" id="wachtwoord" placeholder="Wachtwoord">
                </div>
                
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


