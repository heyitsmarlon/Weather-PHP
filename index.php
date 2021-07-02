<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap v5.0 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Demo -->
    <style>
        .row {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .col {
            max-width: 600px;
            height: 400px;
        }
    </style>
</head>

<body>



    <div class="row">
        <div class="col">
            <!-- Wetter -->
            <?php
            include 'functions.weather.php';
            echo (createWeatherWidget('79541', 'de'));  //zip, location
            ?>
        </div>
    </div>

</body>

</html>