<?php
require_once './header.php';

?>
<main id="upgrade-user">

    <div class="container">
        <div class="row row-left">
            <?php

            if($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php') {
                require_once 'upgrade-step-1.php';
            } elseif ($_SERVER['REQUEST_URI'] == '/I-project/upgrade-user.php?step=2') {
                require_once 'upgrade-step-2.php';
            }
            ?>
        </div>
    </div>
</main>



