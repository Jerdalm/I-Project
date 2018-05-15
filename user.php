<?php require_once 'header.php'; ?>

<main id="login-registration">

    <div class="container">
        <div class="row">
            <?php
            require_once './form-login.php';
            if (isset($message_login)){
                echo '<p class="error error-warning">' . $message_login . '</p>';
            }
            ?>
        <a href="./registreren.php" class="cta-orange">Klik hier om je te registreren!</a>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


