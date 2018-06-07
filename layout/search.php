<?php
require_once '../mechanic/functions.php';
	$dbcon = ConnectToDatabase();
	
    $stmt = $dbcon->prepare("SELECT rubrieknaam FROM laagsteRubrieken");
    $stmt->execute();
    $auto = [];
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                extract($row);
                
               $auto[]=$row['typeahead'];
                
            }
    echo json_encode($auto); // this will display our mysql data in as json format and can only read by js
?>           
