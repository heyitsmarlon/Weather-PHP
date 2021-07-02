<?php
function convertTime($unix_time, $timezone)
{
    $unix_time = $unix_time + $timezone;
    $time = date('H:i:s', $unix_time);
    return $time;
}

function createWeatherWidget($zip, $loc)
{
    $apiKey = 'f20246fe0031204576eef14d5ba486f9';
    #$apiKey = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
    $lang = 'en';
    $units = 'metric';
    // create a new cURL resource
    $request = curl_init();

    // set URL and other appropriate options
    curl_setopt_array($request, array(
        CURLOPT_URL => 'api.openweathermap.org/data/2.5/weather?zip=' . $zip . ',' . $loc . '&lang=' . $lang . '&appid=' . $apiKey . '&units=' . $units . '',
        CURLOPT_RETURNTRANSFER => true
    ));
    // grab URL and pass it to the browser
    $wetter = curl_exec($request);

    // close cURL resource, and free up system resources
    curl_close($request);

    $wetter = json_decode($wetter, true);

    //Set BG
    $bg = array(
        '01d' => 'bg-clear-day',
        '02d' => 'bg-clear-day',
        '03d' => 'bg-cloudy-day',
        '04d' => 'bg-cloudy-day',
        '09d' => 'bg-cloudy-day',
        '10d' => 'bg-cloudy-day',
        '11d' => 'bg-cloudy-night',
        '13d' => 'bg-cloudy-day',
        '50d' => 'bg-cloudy-day',
        '01n' => 'bg-clear-night',
        '02n' => 'bg-clear-night',
        '03n' => 'bg-cloudy-night',
        '04n' => 'bg-cloudy-night',
        '09n' => 'bg-cloudy-night',
        '10n' => 'bg-cloudy-night',
        '11n' => 'bg-cloudy-night',
        '13n' => 'bg-clear-night',
        '50n' => 'bg-cloudy-night'
    );

    // time
    $time = array(
        'local'     =>  convertTime($wetter['dt'], $wetter['timezone']),
        'sunrise'   =>  convertTime($wetter['sys']['sunrise'], $wetter['timezone']),
        'sunset'    =>  convertTime($wetter['sys']['sunset'], $wetter['timezone'])
    );

    //Set BG morning
    if ((($wetter['sys']['sunrise'] - $wetter['dt']) / 3600) < 0.5 && (($wetter['sys']['sunrise'] - $wetter['dt']) / 3600) > -3) {
        $bg = array(
            '01d' => 'bg-clear-morning',
            '02d' => 'bg-clear-morning',
            '03d' => 'bg-cloudy-morning',
            '04d' => 'bg-cloudy-morning',
            '09d' => 'bg-cloudy-morning',
            '10d' => 'bg-cloudy-morning',
            '11d' => 'bg-cloudy-morning',
            '13d' => 'bg-cloudy-morning',
            '50d' => 'bg-cloudy-morning',
            '01n' => 'bg-clear-morning',
            '02n' => 'bg-clear-morning',
            '03n' => 'bg-cloudy-morning',
            '04n' => 'bg-cloudy-morning',
            '09n' => 'bg-cloudy-morning',
            '10n' => 'bg-cloudy-morning',
            '11n' => 'bg-cloudy-morning',
            '13n' => 'bg-clear-morning',
            '50n' => 'bg-cloudy-morning'
        );
    }
    //Set BG evening
    if ((($wetter['sys']['sunset'] - $wetter['dt']) / 3600) < 1 && (($wetter['sys']['sunset'] - $wetter['dt']) / 3600) > -0.5) {
        $bg = array(
            '01d' => 'bg-clear-evening',
            '02d' => 'bg-clear-evening',
            '03d' => 'bg-cloudy-evening',
            '04d' => 'bg-cloudy-evening',
            '09d' => 'bg-cloudy-evening',
            '10d' => 'bg-cloudy-devening',
            '11d' => 'bg-cloudy-evening',
            '13d' => 'bg-cloudy-evening',
            '50d' => 'bg-cloudy-evening',
            '01n' => 'bg-clear-evening',
            '02n' => 'bg-clear-evening',
            '03n' => 'bg-cloudy-evening',
            '04n' => 'bg-cloudy-evening',
            '09n' => 'bg-cloudy-evening',
            '10n' => 'bg-cloudy-evening',
            '11n' => 'bg-cloudy-evening',
            '13n' => 'bg-clear-evening',
            '50n' => 'bg-cloudy-evening'
        );
    }

    $widget = '
    <div class="widget-card ' .  $bg[$wetter["weather"][0]["icon"]]  .  '">
        <div class="card-content">
            
                <div class="card-body">
                    <div class="wetter-container">
                    <div class="wetter-img"><img class="wetter-img" src="assets/' .  $wetter["weather"][0]["icon"]  .  '.png" alt="Wetter in '  .  $wetter["name"]  .  '" draggable="false"></div>
                    <div class="wetter-loc">'  .  $wetter['name']  .  '</div>
                    <div class="wetter-desc">'  .  $wetter['weather'][0]['description']  .  '</div>
                    <div class="wetter-temp">'  .  number_format($wetter['main']['temp'], 1, '.', ' ')  .  '°</div>
                    <div class="wetter-min-max">
                    <div class="wetter-max">H: ' . number_format($wetter['main']['temp_max'], 0, ',', ' ') . '°</div>
                    <div class="wetter-min">T: ' . number_format($wetter['main']['temp_min'], 0, ',', ' ') . '°</div>
                </div>
            </div>
        </div>
    </div>
</div>
    ';
    return ($widget);
}

?>