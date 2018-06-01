<?php
require_once './head.php';
require_once './db.php';

$codeControl = ($_SESSION['code']);	
$emailCheck = $_SESSION['emailRegistration'];

$emailParameters = array(':mailadres' => "$emailCheck");
$emailEquivalent = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres",$emailParameters)[0];

$emailEquivalent['code'] =  trim($emailEquivalent['code']);
$codeControl = trim($codeControl);

if ($emailEquivalent['code'] == $codeControl){
	$_SESSION["step2"] = false;
    $_SESSION["step3"] = true;
    redirectJS("./registratieScherm.php");
} 
else{ 
	echo '<script>alert("helaas")</script>';
}

?>