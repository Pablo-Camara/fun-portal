<?php
ini_set('date.timezone', 'Europe/London');

$domain = $_SERVER['SERVER_NAME'];

function GetIP(){
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

$lunch = isset($_GET['l']) && $_GET['l'] == 1 ? true : false;
$currentHour = (int)date('H');
$greet = $currentHour >= 5 && $currentHour < 13 ? 'Bom dia' : ($currentHour >= 13 && $currentHour <= 18 ? 'Boa tarde' : 'Boa noite');

if($lunch){
    $greet = 'Bom almoço, Até já';
}

try {
    $conn = new PDO("mysql:host=www-do-user-10001768-0.b.db.ondigitalocean.com:25060;dbname=defaultdb", "doadmin", "o2jsBVd23Q5y7Pgo");

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if(isset($_GET['gid'])){
        $sql = 'SELECT id,city,lat,lng FROM geolocation WHERE id = ? LIMIT 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_GET['gid']]);
        $row = $stmt->fetch();

        if (empty($row)) { header('Location: /'); }
    } else {
        $sql = 'SELECT id,city,lat,lng FROM geolocation ORDER BY RAND() LIMIT 1';
        $rows = [];
        foreach ($conn->query($sql) as $row) {
            $rows[] = $row;
        };
    
        $row = $rows[0];

        header('Location: /?gid=' . $row['id'] . ($lunch ? '&l=1' : ''));
    }
   


    $sql = "INSERT INTO history (geolocation_id, ip) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$row['id'], GetIP()]);

    $conn = null;
} catch (PDOException $err) {
    echo "ERROR: Unable to connect: " . $err->getMessage();
}

$qotd = 'QOTD: Concentrate all your thoughts upon the work in hand.';

$metaDesc = 'Gerador de bons dias, boas tardes e boas noites';

if(isset($_GET['gid'])){
    $metaDesc = $qotd;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:site_name" content="<?= $greet . ' ' . $row['city']; ?>.">
    <meta property="og:locale" content="pt_PT">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?=  $greet . ' ' . $row['city']; ?>." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://<?= $domain ?>/?gid=<?= $_GET['gid'] . ($lunch ? '&l=1' : '') ?>" />
    <meta name="description" content="<?= $metaDesc ?>">
    <meta property="og:description" content="<?= $metaDesc ?>" />

    <title><?=  $greet . ' ' . $row['city']; ?>.</title>
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
        <div class="label">

        </div>
        <div class="copy-text" style="margin-bottom: 10px;">
            <input id="greet" type="text" class="text" value="<?= $greet . ' ' . $row['city']; ?>." />
            <button><i class="fa fa-clone"></i></button>
        </div>
        <a href="https://<?= $domain ?><?= ($lunch ? '/?l=1' : '') ?>" style="color: white;padding: 4px;">Refresh</a>
    </div>

    <iframe width="100%" height="600" src="https://www.google.com/maps/embed/v1/view?key=AIzaSyC_DQVcC5Tg6tdX3J4Wmah9GQiuHNd3yIQ&center=<?= $row['lat'] . ',' . $row['lng'] ?>&zoom=16&maptype=satellite"></iframe>

    <!-- partial -->
    <script src="./script.js?v=0.023"></script>

</body>

</html>
