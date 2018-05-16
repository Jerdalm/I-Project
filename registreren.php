<<<<<<< HEAD
<?php require_once './header.php'; ?>
=======
<?php require_once 'header.php'; ?>
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b

<main>
    <div class="container">
        <div class="row">
            <?php

<<<<<<< HEAD
            if($_SERVER['REQUEST_URI'] == 'http://iproject34.icasites.nl/registreren.php' || $_SERVER['REQUEST_URI'] == 'http://iproject34.icasites.nl/registreren.php?step=1') {
                require_once 'form-step-1.php';
            } else if($_SERVER['REQUEST_URI'] == 'http://iproject34.icasites.nl/registreren.php?step=2') {
                require_once 'form-step-2.php';
            } else if($_SERVER['REQUEST_URI'] == 'http://iproject34.icasites.nl/registreren.php?step=3') {
                require_once 'form-step-3.php';
            } else if($_SERVER['REQUEST_URI'] == 'http://iproject34.icasites.nl/registreren.php?step=4') {
=======
            if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php' || $_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=1') {
                require_once 'form-step-1.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=2') {
                require_once 'form-step-2.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=3') {
                require_once 'form-step-3.php';
            } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=4') {
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
                require_once 'form-step-4.php';
            }
            if (isset($message_registration)){
                echo '<p class="error error-warning">' . $message_registration . '</p>';
            }
            ?>
        </div>
    </div>
</main>

<<<<<<< HEAD
<?php require_once './footer.php'; ?>
=======
<?php require_once 'footer.php'; ?>
>>>>>>> 531673006e4de34ccc865c9246f04be90795d13b
