<?php
require_once './mechanic/functions.php';
session_start();
session_destroy();
redirectJS("./");
?>