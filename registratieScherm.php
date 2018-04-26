<?php
require_once 'header.php';
// de error regisration werkt niet
// als we het wachtwoord willen checken op nummer, dan moeten we javascript gebruiken
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

            <?php
            if($_SESSION['step1'] == true) {
                require_once 'form-step-1.php';

            } else if($_SESSION['step2'] == true) {
                require_once 'form-step-2.php';

            } else if($_SESSION['step3'] == true) {
                require_once 'form-step-3.php';

            } else if($_SESSION['step4'] == true) {
                require_once 'form-step-4.php';
            }

            ?>
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
                <a href= "wachtwoordVergeten.php"> Wachtwoord Vergeten? </a><br><br>
                <button type="submit" class="btn btn-primary"> Login</button>
            </form>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


