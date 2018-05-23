<?php require_once './header.php'; ?>

<main>
    <section>
        <div class="container">
            <div class="row">
                <?php
                
                if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php' || $_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=1') {
                    require_once 'form-step-1.php';
                    $actualvalue = 25;
                } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=2') {
                    require_once 'form-step-2.php';
                    $actualvalue = 50;
                } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=3') {
                    require_once 'form-step-3.php';
                    $actualvalue = 75;
                } else if($_SERVER['REQUEST_URI'] == '/I-Project/registreren.php?step=4') {
                    require_once 'form-step-4.php';
                    $actualvalue = 100;
                }
                if (isset($message_registration)){
                    echo '<p class="error error-warning">' . $message_registration . '</p>';
                }
                ?>
            </div>
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: <?=$actualvalue?>%; background-color: #F2552C" role="progressbar" aria-valuenow="<?=$actualvalue?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </section>
</main>

<?php require_once './footer.php'; ?>