<?php
require_once './head.php';
require_once './db.php';

$codeControl = ($_SESSION['code']);	
$emailCheck = $_SESSION['emailRegistration'];

$emailParameters = array(':mailadres' => "$emailCheck");
$emailEquivalent = handleQuery("SELECT * FROM ActivatieCode WHERE mailadres = :mailadres",$emailParameters)[0];

print_r($emailEquivalent);
foreach ($emailEquivalent as $item) {
	echo $item[0][0];
}


?>