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


            <?php } elseif(isset($_POST['code'])) {
                require_once 'form-step-3.php';
                ?>

            <?php  }elseif(isset($_POST['submitNaam'])) {
                $_SESSION["sumbitNaam"] = true;
                header("location: ./nameAndPasswordCheck");
                }
            ?>

            <?php if($_SESSION['sumbitNaam'] == true) {
                require_once 'form-step-4.php';?>


            <?php }
            if ($_SESSION["mailButton"] == false) {
                require_once 'form-step-1.php'; ?>


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


