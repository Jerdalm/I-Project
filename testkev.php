<?php

/* In deze functie wordt de afstand in tijd en km berekend tussen 2 locaties|Invoer: stad/dorp/postcode */
function getDistanceData($cityUser,$citySeller){
$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=".$cityUser."&destinations=".$citySeller."&language=nl-NL&sensor=false");
$data = json_decode($data, true);

$time = $data['rows'][0]['elements'][0]['duration']['text']; //Text for String and Value for INT
$distance = $data['rows'][0]['elements'][0]['distance']['value'];//Text for String and Value for INT
$distanceKm = round($distance / 1000);

return array('time' => $time, 'distance' => $distanceKm);
}

?>
