<?php require_once 'header.php'; ?>

<main id="login">
    <section>
        <div class="container">
            <div class="row justify-content-md-center">
                <?php
                require_once './form-login.php';
                if (isset($message_login)){
                    echo '<p class="error error-warning">' . $message_login . '</p>';
                }
                ?>
            </div>
        </div>
    </section>
</main>
<?php include 'footer.php'; ?>


