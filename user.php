<?php require_once 'header.php'; ?>

<main id="login">
    <section>
        <div class="container">
            <div class="row">
                <?php
                require_once './form-login.php';
                if (isset($message_login)){
                    echo '<p class="error error-warning">' . $message_login . '</p>';
                }
                ?>
                <a href="./registreren.php" class="cta-orange btn ">Klik hier om je te registreren!</a>
            </div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>


