<?php
session_start();
echo md5(111111);
echo '<br>';
echo md5('111111');
echo '<br>';
echo $_SESSION['hashedcode'];