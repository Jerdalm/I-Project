<?php
$emailCheck = ($POST['email']);
$email_unique = $dbh->query("SELECT * FROM Account WHERE email='$emailCheck'"); //check hier of alles wel klopt
if(strlen($emailCheck) != 0 ){
    if($email_unique->rowCount() == 0) {
        if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
            //maildingetje
        } else {
            $_SESSION['error_registatrion'] = 'Geen gelding e-mailadres.';
        }
    } else {
        $_SESSION['error_registatrion'] = 'Er bestaat al een account met dit emailadres.';
    }
} else{
    $_SESSION['error_registatrion'] = 'Geen invoer.';
}
?>