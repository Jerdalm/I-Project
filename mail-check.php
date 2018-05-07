<?php
require_once './head.php';
require_once './db.php';

$emailCheck = ($_SESSION['emailRegistration']);

$_SESSION['randomVerificationCode'] = rand(100000,900000);
$randomNumber = ($_SESSION['randomVerificationCode']);

$emailParameters = array(':mailadres' => "$emailCheck");
// $emailUnique = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres",$emailParameters);

// $emailParameters = array(':mailadres' => "$emailCheck");
// $emailUnique = handleQuery("SELECT * FROM Gebruiker WHERE mailadres = :mailadres",$emailParameters);


$to      = $emailCheck;
$subject = 'Account activatie';
$message_body = '
Beste,

Bedankt voor het registreren!

Voer deze code in op de site:
' .$randomNumber.'.';
$message = 'Er is een email met de verifiactiecode naar het opgegeven emailadres gestuurt.';

if(strlen($emailCheck) != 0){
   // if($emailUnique) {
    if (filter_var($emailCheck, FILTER_VALIDATE_EMAIL)) {
        handleQuery("INSERT INTO ActivatieCode VALUES (0 ,$randomNumber ,:mailadres, GETDATE())",$emailParameters);
        sendMail($to, $subject, $message_body, $message);
        $_SESSION["step1"] = false;
        $_SESSION["step2"] = true;
        header("location: ./registratieScherm.php");

    } else {
        $_SESSION['error_registatrion'] = 'Geen gelding e-mailadres.';
        header("location: ./registratieScherm.php");
    }
   // } else {
   //     $_SESSION['error_registatrion'] = 'Er bestaat al een account met dit emailadres.';
   //     header("location: ./registratieScherm.php");
   // }
} else{
    $_SESSION['error_registatrion'] = 'Geen invoer.';
    header("location: ./registratieScherm.php");
}
?>