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

    if (!is_null($geoLocationId)) {
        $geoLocation = GeoLocation::getById($geoLocationId);
        if (empty($geoLocation)) {
            header('Location: /');
        }
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

if (!is_null($geoLocationId)) {
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
    <meta property="og:title" content="<?= $greet . ' ' . $geoLocation['city']; ?>." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= UrlHelper::getFullUrl($forceLunchGreet, $countryCode, $geoLocationId) ?>" />
    <meta name="description" content="<?= $metaDesc ?>">
    <meta property="og:description" content="<?= $metaDesc ?>" />

    <title><?= $greet . ' ' . $geoLocation['city']; ?>.</title>
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
    <div>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SY') ?>"><img src="/assets/img/flags/4x3/SY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JO') ?>"><img src="/assets/img/flags/4x3/JO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AE') ?>"><img src="/assets/img/flags/4x3/AE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IL') ?>"><img src="/assets/img/flags/4x3/IL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IR') ?>"><img src="/assets/img/flags/4x3/IR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'YE') ?>"><img src="/assets/img/flags/4x3/YE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'OM') ?>"><img src="/assets/img/flags/4x3/OM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DZ') ?>"><img src="/assets/img/flags/4x3/DZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MA') ?>"><img src="/assets/img/flags/4x3/MA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NL') ?>"><img src="/assets/img/flags/4x3/NL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ES') ?>"><img src="/assets/img/flags/4x3/ES.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DE') ?>"><img src="/assets/img/flags/4x3/DE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CH') ?>"><img src="/assets/img/flags/4x3/CH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DK') ?>"><img src="/assets/img/flags/4x3/DK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BE') ?>"><img src="/assets/img/flags/4x3/BE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FI') ?>"><img src="/assets/img/flags/4x3/FI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GL') ?>"><img src="/assets/img/flags/4x3/GL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NG') ?>"><img src="/assets/img/flags/4x3/NG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TM') ?>"><img src="/assets/img/flags/4x3/TM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BR') ?>"><img src="/assets/img/flags/4x3/BR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PY') ?>"><img src="/assets/img/flags/4x3/PY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RU') ?>"><img src="/assets/img/flags/4x3/RU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PE') ?>"><img src="/assets/img/flags/4x3/PE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IT') ?>"><img src="/assets/img/flags/4x3/IT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JP') ?>"><img src="/assets/img/flags/4x3/JP.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MX') ?>"><img src="/assets/img/flags/4x3/MX.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FR') ?>"><img src="/assets/img/flags/4x3/FR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GB') ?>"><img src="/assets/img/flags/4x3/GB.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CA') ?>"><img src="/assets/img/flags/4x3/CA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PK') ?>"><img src="/assets/img/flags/4x3/PK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TJ') ?>"><img src="/assets/img/flags/4x3/TJ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TD') ?>"><img src="/assets/img/flags/4x3/TD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CI') ?>"><img src="/assets/img/flags/4x3/CI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SA') ?>"><img src="/assets/img/flags/4x3/SA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'US') ?>"><img src="/assets/img/flags/4x3/US.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UG') ?>"><img src="/assets/img/flags/4x3/UG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'EG') ?>"><img src="/assets/img/flags/4x3/EG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IN') ?>"><img src="/assets/img/flags/4x3/IN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BJ') ?>"><img src="/assets/img/flags/4x3/BJ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CM') ?>"><img src="/assets/img/flags/4x3/CM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HU') ?>"><img src="/assets/img/flags/4x3/HU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PH') ?>"><img src="/assets/img/flags/4x3/PH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AM') ?>"><img src="/assets/img/flags/4x3/AM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AR') ?>"><img src="/assets/img/flags/4x3/AR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CU') ?>"><img src="/assets/img/flags/4x3/CU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RO') ?>"><img src="/assets/img/flags/4x3/RO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AT') ?>"><img src="/assets/img/flags/4x3/AT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SD') ?>"><img src="/assets/img/flags/4x3/SD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KW') ?>"><img src="/assets/img/flags/4x3/KW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CO') ?>"><img src="/assets/img/flags/4x3/CO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SV') ?>"><img src="/assets/img/flags/4x3/SV.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VE') ?>"><img src="/assets/img/flags/4x3/VE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GH') ?>"><img src="/assets/img/flags/4x3/GH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BO') ?>"><img src="/assets/img/flags/4x3/BO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GQ') ?>"><img src="/assets/img/flags/4x3/GQ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SM') ?>"><img src="/assets/img/flags/4x3/SM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IQ') ?>"><img src="/assets/img/flags/4x3/IQ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RS') ?>"><img src="/assets/img/flags/4x3/RS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PN') ?>"><img src="/assets/img/flags/4x3/PN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TR') ?>"><img src="/assets/img/flags/4x3/TR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LV') ?>"><img src="/assets/img/flags/4x3/LV.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ET') ?>"><img src="/assets/img/flags/4x3/ET.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AU') ?>"><img src="/assets/img/flags/4x3/AU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ER') ?>"><img src="/assets/img/flags/4x3/ER.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'WS') ?>"><img src="/assets/img/flags/4x3/WS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NE') ?>"><img src="/assets/img/flags/4x3/NE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CN') ?>"><img src="/assets/img/flags/4x3/CN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TN') ?>"><img src="/assets/img/flags/4x3/TN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AZ') ?>"><img src="/assets/img/flags/4x3/AZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GR') ?>"><img src="/assets/img/flags/4x3/GR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CY') ?>"><img src="/assets/img/flags/4x3/CY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GT') ?>"><img src="/assets/img/flags/4x3/GT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PR') ?>"><img src="/assets/img/flags/4x3/PR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PT') ?>"><img src="/assets/img/flags/4x3/PT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ML') ?>"><img src="/assets/img/flags/4x3/ML.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UA') ?>"><img src="/assets/img/flags/4x3/UA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AF') ?>"><img src="/assets/img/flags/4x3/AF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UY') ?>"><img src="/assets/img/flags/4x3/UY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TL') ?>"><img src="/assets/img/flags/4x3/TL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MR') ?>"><img src="/assets/img/flags/4x3/MR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LY') ?>"><img src="/assets/img/flags/4x3/LY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SI') ?>"><img src="/assets/img/flags/4x3/SI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TH') ?>"><img src="/assets/img/flags/4x3/TH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CD') ?>"><img src="/assets/img/flags/4x3/CD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GE') ?>"><img src="/assets/img/flags/4x3/GE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IS') ?>"><img src="/assets/img/flags/4x3/IS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NO') ?>"><img src="/assets/img/flags/4x3/NO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BG') ?>"><img src="/assets/img/flags/4x3/BG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'QA') ?>"><img src="/assets/img/flags/4x3/QA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BH') ?>"><img src="/assets/img/flags/4x3/BH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XW') ?>"><img src="/assets/img/flags/4x3/XW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CR') ?>"><img src="/assets/img/flags/4x3/CR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KG') ?>"><img src="/assets/img/flags/4x3/KG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'EC') ?>"><img src="/assets/img/flags/4x3/EC.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ZA') ?>"><img src="/assets/img/flags/4x3/ZA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SR') ?>"><img src="/assets/img/flags/4x3/SR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PL') ?>"><img src="/assets/img/flags/4x3/PL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CL') ?>"><img src="/assets/img/flags/4x3/CL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NZ') ?>"><img src="/assets/img/flags/4x3/NZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KZ') ?>"><img src="/assets/img/flags/4x3/KZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DJ') ?>"><img src="/assets/img/flags/4x3/DJ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MM') ?>"><img src="/assets/img/flags/4x3/MM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PA') ?>"><img src="/assets/img/flags/4x3/PA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NU') ?>"><img src="/assets/img/flags/4x3/NU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MY') ?>"><img src="/assets/img/flags/4x3/MY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PG') ?>"><img src="/assets/img/flags/4x3/PG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LT') ?>"><img src="/assets/img/flags/4x3/LT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ID') ?>"><img src="/assets/img/flags/4x3/ID.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MG') ?>"><img src="/assets/img/flags/4x3/MG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AO') ?>"><img src="/assets/img/flags/4x3/AO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LB') ?>"><img src="/assets/img/flags/4x3/LB.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IE') ?>"><img src="/assets/img/flags/4x3/IE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UZ') ?>"><img src="/assets/img/flags/4x3/UZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KR') ?>"><img src="/assets/img/flags/4x3/KR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AD') ?>"><img src="/assets/img/flags/4x3/AD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ME') ?>"><img src="/assets/img/flags/4x3/ME.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MD') ?>"><img src="/assets/img/flags/4x3/MD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KP') ?>"><img src="/assets/img/flags/4x3/KP.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GY') ?>"><img src="/assets/img/flags/4x3/GY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LA') ?>"><img src="/assets/img/flags/4x3/LA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MZ') ?>"><img src="/assets/img/flags/4x3/MZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LK') ?>"><img src="/assets/img/flags/4x3/LK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VN') ?>"><img src="/assets/img/flags/4x3/VN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MK') ?>"><img src="/assets/img/flags/4x3/MK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TT') ?>"><img src="/assets/img/flags/4x3/TT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TZ') ?>"><img src="/assets/img/flags/4x3/TZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MN') ?>"><img src="/assets/img/flags/4x3/MN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BY') ?>"><img src="/assets/img/flags/4x3/BY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CV') ?>"><img src="/assets/img/flags/4x3/CV.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TG') ?>"><img src="/assets/img/flags/4x3/TG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KE') ?>"><img src="/assets/img/flags/4x3/KE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MT') ?>"><img src="/assets/img/flags/4x3/MT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SB') ?>"><img src="/assets/img/flags/4x3/SB.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CK') ?>"><img src="/assets/img/flags/4x3/CK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SS') ?>"><img src="/assets/img/flags/4x3/SS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DO') ?>"><img src="/assets/img/flags/4x3/DO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FJ') ?>"><img src="/assets/img/flags/4x3/FJ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CF') ?>"><img src="/assets/img/flags/4x3/CF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TW') ?>"><img src="/assets/img/flags/4x3/TW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GW') ?>"><img src="/assets/img/flags/4x3/GW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NP') ?>"><img src="/assets/img/flags/4x3/NP.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SO') ?>"><img src="/assets/img/flags/4x3/SO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AL') ?>"><img src="/assets/img/flags/4x3/AL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CZ') ?>"><img src="/assets/img/flags/4x3/CZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MW') ?>"><img src="/assets/img/flags/4x3/MW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LI') ?>"><img src="/assets/img/flags/4x3/LI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BN') ?>"><img src="/assets/img/flags/4x3/BN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BF') ?>"><img src="/assets/img/flags/4x3/BF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BA') ?>"><img src="/assets/img/flags/4x3/BA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GM') ?>"><img src="/assets/img/flags/4x3/GM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KH') ?>"><img src="/assets/img/flags/4x3/KH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SK') ?>"><img src="/assets/img/flags/4x3/SK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LR') ?>"><img src="/assets/img/flags/4x3/LR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BD') ?>"><img src="/assets/img/flags/4x3/BD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LU') ?>"><img src="/assets/img/flags/4x3/LU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GP') ?>"><img src="/assets/img/flags/4x3/GP.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KN') ?>"><img src="/assets/img/flags/4x3/KN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HR') ?>"><img src="/assets/img/flags/4x3/HR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ZW') ?>"><img src="/assets/img/flags/4x3/ZW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BZ') ?>"><img src="/assets/img/flags/4x3/BZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HT') ?>"><img src="/assets/img/flags/4x3/HT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NA') ?>"><img src="/assets/img/flags/4x3/NA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GN') ?>"><img src="/assets/img/flags/4x3/GN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GA') ?>"><img src="/assets/img/flags/4x3/GA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NI') ?>"><img src="/assets/img/flags/4x3/NI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JM') ?>"><img src="/assets/img/flags/4x3/JM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SL') ?>"><img src="/assets/img/flags/4x3/SL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SE') ?>"><img src="/assets/img/flags/4x3/SE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CG') ?>"><img src="/assets/img/flags/4x3/CG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XK') ?>"><img src="/assets/img/flags/4x3/XK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BB') ?>"><img src="/assets/img/flags/4x3/BB.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HN') ?>"><img src="/assets/img/flags/4x3/HN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BI') ?>"><img src="/assets/img/flags/4x3/BI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RW') ?>"><img src="/assets/img/flags/4x3/RW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LS') ?>"><img src="/assets/img/flags/4x3/LS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MU') ?>"><img src="/assets/img/flags/4x3/MU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MP') ?>"><img src="/assets/img/flags/4x3/MP.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LC') ?>"><img src="/assets/img/flags/4x3/LC.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GF') ?>"><img src="/assets/img/flags/4x3/GF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ZM') ?>"><img src="/assets/img/flags/4x3/ZM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FM') ?>"><img src="/assets/img/flags/4x3/FM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BT') ?>"><img src="/assets/img/flags/4x3/BT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SN') ?>"><img src="/assets/img/flags/4x3/SN.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MV') ?>"><img src="/assets/img/flags/4x3/MV.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IM') ?>"><img src="/assets/img/flags/4x3/IM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SH') ?>"><img src="/assets/img/flags/4x3/SH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FO') ?>"><img src="/assets/img/flags/4x3/FO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'EE') ?>"><img src="/assets/img/flags/4x3/EE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CX') ?>"><img src="/assets/img/flags/4x3/CX.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KM') ?>"><img src="/assets/img/flags/4x3/KM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MQ') ?>"><img src="/assets/img/flags/4x3/MQ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BW') ?>"><img src="/assets/img/flags/4x3/BW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BS') ?>"><img src="/assets/img/flags/4x3/BS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TV') ?>"><img src="/assets/img/flags/4x3/TV.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XG') ?>"><img src="/assets/img/flags/4x3/XG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KY') ?>"><img src="/assets/img/flags/4x3/KY.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GI') ?>"><img src="/assets/img/flags/4x3/GI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TC') ?>"><img src="/assets/img/flags/4x3/TC.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GS') ?>"><img src="/assets/img/flags/4x3/GS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BL') ?>"><img src="/assets/img/flags/4x3/BL.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GU') ?>"><img src="/assets/img/flags/4x3/GU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BM') ?>"><img src="/assets/img/flags/4x3/BM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SZ') ?>"><img src="/assets/img/flags/4x3/SZ.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HK') ?>"><img src="/assets/img/flags/4x3/HK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VU') ?>"><img src="/assets/img/flags/4x3/VU.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VC') ?>"><img src="/assets/img/flags/4x3/VC.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NC') ?>"><img src="/assets/img/flags/4x3/NC.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PW') ?>"><img src="/assets/img/flags/4x3/PW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'WF') ?>"><img src="/assets/img/flags/4x3/WF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XR') ?>"><img src="/assets/img/flags/4x3/XR.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MO') ?>"><img src="/assets/img/flags/4x3/MO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MH') ?>"><img src="/assets/img/flags/4x3/MH.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'YT') ?>"><img src="/assets/img/flags/4x3/YT.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MF') ?>"><img src="/assets/img/flags/4x3/MF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MC') ?>"><img src="/assets/img/flags/4x3/MC.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TO') ?>"><img src="/assets/img/flags/4x3/TO.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ST') ?>"><img src="/assets/img/flags/4x3/ST.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AW') ?>"><img src="/assets/img/flags/4x3/AW.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AS') ?>"><img src="/assets/img/flags/4x3/AS.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PF') ?>"><img src="/assets/img/flags/4x3/PF.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SX') ?>"><img src="/assets/img/flags/4x3/SX.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VG') ?>"><img src="/assets/img/flags/4x3/VG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DM') ?>"><img src="/assets/img/flags/4x3/DM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GD') ?>"><img src="/assets/img/flags/4x3/GD.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JE') ?>"><img src="/assets/img/flags/4x3/JE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AG') ?>"><img src="/assets/img/flags/4x3/AG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RE') ?>"><img src="/assets/img/flags/4x3/RE.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PM') ?>"><img src="/assets/img/flags/4x3/PM.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SG') ?>"><img src="/assets/img/flags/4x3/SG.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FK') ?>"><img src="/assets/img/flags/4x3/FK.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KI') ?>"><img src="/assets/img/flags/4x3/KI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AI') ?>"><img src="/assets/img/flags/4x3/AI.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VA') ?>"><img src="/assets/img/flags/4x3/VA.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CW') ?>"><img src="/assets/img/flags/4x3/CW.svg" width="30" /></a>

    </div>
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