<?php
$_SESSION['logged-in'] = false;
session_destroy();
header("location: ./");
?>