<?php require_once 'header.php'; ?>

<main>
    <div class="container">
        <div class="row">
            <?php

            if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php' || $_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=1') {
                require_once 'form-step-1.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=2') {
                require_once 'form-step-2.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=3') {
                require_once 'form-step-3.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=4') {
                require_once 'form-step-4.php';
            }
            if (isset($message_registration)){
                echo '<p class="error error-warning">' . $message_registration . '</p>';
            }
            ?>
        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?>