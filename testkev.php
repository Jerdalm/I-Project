<?php 
$data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=amsterdam&destinations=rotterdam&language=en-EN&sensor=false");
$data = json_decode($data, true);

$time = $data['rows'][0]['elements'][0]['duration']['value']; //Text for String and Value for INT
$distance = $data['rows'][0]['elements'][0]['distance']['value'];//Text for String and Value for INT

echo $time;
echo $distance;

$time = 0;
$distance = 0;
?>