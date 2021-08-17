<?php

$user_ip = getenv('REMOTE_ADDR');
$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
$country = $geo["geoplugin_countryName"];
$city = $geo["geoplugin_city"];

header("Content-Type: application/json; charset=UTF-8");

$APIkey = "ef4848fce58d8fd9533c99b1280accee";

$url = "api.openweathermap.org/data/2.5/weather?q=$city&appid=$APIkey";

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($curl);
curl_close($curl);
var_dump(json_decode($result, true));
?>

