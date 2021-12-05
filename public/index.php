<?php
ini_set('date.timezone', 'Europe/London');

require_once './src/classes/Database.php';
require_once './src/classes/UserConnection.php';
require_once './src/classes/UrlHelper.php';
require_once './src/classes/Greeting.php';
require_once './src/classes/GeoLocation.php';
require_once './src/classes/History.php';


$geoLocationId = isset($_GET['gid']) && !empty($_GET['gid']) ? $_GET['gid'] : null;
$countryCode = isset($_GET['c']) && !empty($_GET['c']) ? $_GET['c'] : null;
$forceLunchGreet = isset($_GET['l']) && $_GET['l'] == 1 ? true : false;
$greet = Greeting::greet($forceLunchGreet);

try {
    
    if(!is_null($geoLocationId)){
        $geoLocation = GeoLocation::getById($geoLocationId);
        if (empty($geoLocation)) { header('Location: /'); }
    } else {
        $geoLocation = GeoLocation::getRandomGeoLocation($countryCode);
        header('Location: ' . UrlHelper::getFullUrl($forceLunchGreet, $countryCode, $geoLocation['id']));
    }

    History::storeGeoLocationHistory($geoLocation['id'], UserConnection::getIP());
    
} catch (PDOException $err) {
    echo "ERROR: Unable to connect: " . $err->getMessage();
}

//$qotd = 'QOTD: Concentrate all your thoughts upon the work in hand.';
$qotd = 'QOTD: The future depends on what you do today.';

$metaDesc = 'Gerador de bons dias, boas tardes e boas noites';

if(!is_null($geoLocationId)){
    $metaDesc = $qotd;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:site_name" content="<?= $greet . ' ' . $geoLocation['city']; ?>.">
    <meta property="og:locale" content="pt_PT">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?=  $greet . ' ' . $geoLocation['city']; ?>." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= UrlHelper::getFullUrl($forceLunchGreet, $countryCode, $geoLocationId) ?>" />
    <meta name="description" content="<?= $metaDesc ?>">
    <meta property="og:description" content="<?= $metaDesc ?>" />

    <title><?=  $greet . ' ' . $geoLocation['city']; ?>.</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
        }

        body {
            font-family: "Roboto", sans-serif;
            background: #f0f2f7;
        }

        .container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .label {
            padding: 10px;
            font-size: 18px;
            color: #111;
        }

        .copy-text {
            position: relative;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            display: flex;
        }

        .copy-text input.text {
            padding: 10px;
            font-size: 18px;
            color: #555;
            border: none;
            outline: none;
        }

        .copy-text button {
            padding: 10px;
            background: #5784f5;
            color: #fff;
            font-size: 18px;
            border: none;
            outline: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .copy-text button:active {
            background: #809ce2;
        }

        .copy-text button:before {
            content: "Copied";
            position: absolute;
            top: -45px;
            right: 0px;
            background: #5c81dc;
            padding: 8px 10px;
            border-radius: 20px;
            font-size: 15px;
            display: none;
        }

        .copy-text button:after {
            content: "";
            position: absolute;
            top: -20px;
            right: 25px;
            width: 10px;
            height: 10px;
            background: #5c81dc;
            transform: rotate(45deg);
            display: none;
        }

        .copy-text.active button:before,
        .copy-text.active button:after {
            display: block;
        }

        footer {
            position: fixed;
            height: 50px;
            width: 100%;
            left: 0;
            bottom: 0;
            background-color: #5784f5;
            color: white;
            text-align: center;
        }

        footer p {
            margin: revert;
            padding: revert;
        }
    </style>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="container" style="top: 20%">
        <div class="copy-text" style="margin-bottom: 10px;">
            <input id="greet" type="text" class="text" value="<?= $greet . ' ' . $geoLocation['city']; ?>." />
            <button><i class="fa fa-clone"></i></button>
        </div>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, $countryCode) ?>" style="color: white;padding: 4px;">Refresh</a>
    </div>

    <iframe width="100%" height="600" src="https://www.google.com/maps/embed/v1/view?key=AIzaSyC_DQVcC5Tg6tdX3J4Wmah9GQiuHNd3yIQ&center=<?= $geoLocation['lat'] . ',' . $geoLocation['lng'] ?>&zoom=16&maptype=satellite"></iframe>

    <!-- partial -->
    <script src="/assets/js/script.js?v=0.023"></script>

</body>

</html>
