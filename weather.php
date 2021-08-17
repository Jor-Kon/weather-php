<?php
date_default_timezone_set('Poland');

$user_ip = getenv('REMOTE_ADDR');
$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
$country = $geo["geoplugin_countryName"];
$city = $geo["geoplugin_city"];

$APIkey = "ef4848fce58d8fd9533c99b1280accee";
$url = "api.openweathermap.org/data/2.5/weather?q=$city&lang=en&units=metric&&appid=$APIkey";
$curl = curl_init($url);

curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
curl_close($curl);
$json = json_decode($response, true);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Weather</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">
            <img src="weather-icon.png" width="30" height="30" class="mx-auto">    
            Weather
        </a>

        <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </ul>
            <ul class="form-inline my-lg-0 me-2">
                <a href="index.php" class="btn btn-primary">Logout</a>
            </ul>
        </div>
    </nav>
    <div class="mx-auto" style="width: 200px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5"><?php echo $json["name"]; ?></h2>
                    <div class="text-secondary">
                        <div><b><?php echo date("l H:i", time()); ?></b></div>
                        <div><b><?php echo date("j-m-y", time()); ?></b></div>
                    </div>
                    <h1><?php echo $json["main"]["temp"]; ?>°C</h1>
                    <div class="text-secondary">
                        <img src="http://openweathermap.org/img/w/<?php echo $json["weather"][0]["icon"]; ?>.png" class="weather-icon" />
                        <b><?php echo $json["weather"][0]["description"]; ?></b>
                        <div>Humidity: <b><?php echo $json["main"]["humidity"]; ?>%</b></div>
                        <div>Wind: <b><?php echo $json["wind"]["speed"]; ?>km/h</b></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>