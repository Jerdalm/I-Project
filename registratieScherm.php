<?php
require_once 'header.php';
session_start();
?>
<main id="login-registration">

    <div class="container">
        <div class="row row-left">

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
            <?php
                require_once './form-login.php';
            ?>

        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


