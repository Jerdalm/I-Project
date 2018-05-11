<?php require_once 'header.php'; ?>

<main id="login-registration">

    <div class="container">
        <div class="row row-left">
            <?php

            if($_SERVER['REQUEST_URI'] == '/I-Project/user.php' || $_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=1') {
                require_once 'form-step-1.php';

            } else if($_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=2') {
                require_once 'form-step-2.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=3') {
                require_once 'form-step-3.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/user.php?step=4') {
                require_once 'form-step-4.php';
            }
            if (isset($message_registration)){
                echo '<p class="error error-warning">' . $message_registration . '</p>';
            }
            ?>
        </div>

        <div class="row row-right">
            <?php
            require_once './form-login.php';
            if (isset($message_login)){
                echo '<p class="error error-warning">' . $message_login . '</p>';
            }
            ?>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>


