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
    <div style="
    position: absolute;
    width: 50px;
    right: 0;
    overflow: auto;
    height: 600px;
    text-align: center;
">
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SY') ?>"><img src="/assets/img/flags/4x3/sy.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JO') ?>"><img src="/assets/img/flags/4x3/jo.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AE') ?>"><img src="/assets/img/flags/4x3/ae.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IL') ?>"><img src="/assets/img/flags/4x3/il.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IR') ?>"><img src="/assets/img/flags/4x3/ir.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'YE') ?>"><img src="/assets/img/flags/4x3/ye.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'OM') ?>"><img src="/assets/img/flags/4x3/om.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DZ') ?>"><img src="/assets/img/flags/4x3/dz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MA') ?>"><img src="/assets/img/flags/4x3/ma.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NL') ?>"><img src="/assets/img/flags/4x3/nl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ES') ?>"><img src="/assets/img/flags/4x3/es.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DE') ?>"><img src="/assets/img/flags/4x3/de.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CH') ?>"><img src="/assets/img/flags/4x3/ch.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DK') ?>"><img src="/assets/img/flags/4x3/dk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BE') ?>"><img src="/assets/img/flags/4x3/be.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FI') ?>"><img src="/assets/img/flags/4x3/fi.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GL') ?>"><img src="/assets/img/flags/4x3/gl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NG') ?>"><img src="/assets/img/flags/4x3/ng.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TM') ?>"><img src="/assets/img/flags/4x3/tm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BR') ?>"><img src="/assets/img/flags/4x3/br.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PY') ?>"><img src="/assets/img/flags/4x3/py.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RU') ?>"><img src="/assets/img/flags/4x3/ru.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PE') ?>"><img src="/assets/img/flags/4x3/pe.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IT') ?>"><img src="/assets/img/flags/4x3/it.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JP') ?>"><img src="/assets/img/flags/4x3/jp.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MX') ?>"><img src="/assets/img/flags/4x3/mx.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FR') ?>"><img src="/assets/img/flags/4x3/fr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GB') ?>"><img src="/assets/img/flags/4x3/gb.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CA') ?>"><img src="/assets/img/flags/4x3/ca.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PK') ?>"><img src="/assets/img/flags/4x3/pk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TJ') ?>"><img src="/assets/img/flags/4x3/tj.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TD') ?>"><img src="/assets/img/flags/4x3/td.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CI') ?>"><img src="/assets/img/flags/4x3/ci.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SA') ?>"><img src="/assets/img/flags/4x3/sa.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'US') ?>"><img src="/assets/img/flags/4x3/us.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UG') ?>"><img src="/assets/img/flags/4x3/ug.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'EG') ?>"><img src="/assets/img/flags/4x3/eg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IN') ?>"><img src="/assets/img/flags/4x3/in.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BJ') ?>"><img src="/assets/img/flags/4x3/bj.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CM') ?>"><img src="/assets/img/flags/4x3/cm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HU') ?>"><img src="/assets/img/flags/4x3/hu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PH') ?>"><img src="/assets/img/flags/4x3/ph.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AM') ?>"><img src="/assets/img/flags/4x3/am.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AR') ?>"><img src="/assets/img/flags/4x3/ar.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CU') ?>"><img src="/assets/img/flags/4x3/cu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RO') ?>"><img src="/assets/img/flags/4x3/ro.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AT') ?>"><img src="/assets/img/flags/4x3/at.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SD') ?>"><img src="/assets/img/flags/4x3/sd.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KW') ?>"><img src="/assets/img/flags/4x3/kw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CO') ?>"><img src="/assets/img/flags/4x3/co.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SV') ?>"><img src="/assets/img/flags/4x3/sv.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VE') ?>"><img src="/assets/img/flags/4x3/ve.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GH') ?>"><img src="/assets/img/flags/4x3/gh.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BO') ?>"><img src="/assets/img/flags/4x3/bo.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GQ') ?>"><img src="/assets/img/flags/4x3/gq.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SM') ?>"><img src="/assets/img/flags/4x3/sm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IQ') ?>"><img src="/assets/img/flags/4x3/iq.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RS') ?>"><img src="/assets/img/flags/4x3/rs.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PN') ?>"><img src="/assets/img/flags/4x3/pn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TR') ?>"><img src="/assets/img/flags/4x3/tr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LV') ?>"><img src="/assets/img/flags/4x3/lv.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ET') ?>"><img src="/assets/img/flags/4x3/et.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AU') ?>"><img src="/assets/img/flags/4x3/au.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ER') ?>"><img src="/assets/img/flags/4x3/er.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'WS') ?>"><img src="/assets/img/flags/4x3/ws.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NE') ?>"><img src="/assets/img/flags/4x3/ne.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CN') ?>"><img src="/assets/img/flags/4x3/cn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TN') ?>"><img src="/assets/img/flags/4x3/tn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AZ') ?>"><img src="/assets/img/flags/4x3/az.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GR') ?>"><img src="/assets/img/flags/4x3/gr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CY') ?>"><img src="/assets/img/flags/4x3/cy.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GT') ?>"><img src="/assets/img/flags/4x3/gt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PR') ?>"><img src="/assets/img/flags/4x3/pr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PT') ?>"><img src="/assets/img/flags/4x3/pt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ML') ?>"><img src="/assets/img/flags/4x3/ml.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UA') ?>"><img src="/assets/img/flags/4x3/ua.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AF') ?>"><img src="/assets/img/flags/4x3/af.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UY') ?>"><img src="/assets/img/flags/4x3/uy.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TL') ?>"><img src="/assets/img/flags/4x3/tl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MR') ?>"><img src="/assets/img/flags/4x3/mr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LY') ?>"><img src="/assets/img/flags/4x3/ly.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SI') ?>"><img src="/assets/img/flags/4x3/si.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TH') ?>"><img src="/assets/img/flags/4x3/th.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CD') ?>"><img src="/assets/img/flags/4x3/cd.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GE') ?>"><img src="/assets/img/flags/4x3/ge.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IS') ?>"><img src="/assets/img/flags/4x3/is.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NO') ?>"><img src="/assets/img/flags/4x3/no.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BG') ?>"><img src="/assets/img/flags/4x3/bg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'QA') ?>"><img src="/assets/img/flags/4x3/qa.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BH') ?>"><img src="/assets/img/flags/4x3/bh.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XW') ?>"><img src="/assets/img/flags/4x3/xw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CR') ?>"><img src="/assets/img/flags/4x3/cr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KG') ?>"><img src="/assets/img/flags/4x3/kg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'EC') ?>"><img src="/assets/img/flags/4x3/ec.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ZA') ?>"><img src="/assets/img/flags/4x3/za.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SR') ?>"><img src="/assets/img/flags/4x3/sr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PL') ?>"><img src="/assets/img/flags/4x3/pl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CL') ?>"><img src="/assets/img/flags/4x3/cl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NZ') ?>"><img src="/assets/img/flags/4x3/nz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KZ') ?>"><img src="/assets/img/flags/4x3/kz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DJ') ?>"><img src="/assets/img/flags/4x3/dj.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MM') ?>"><img src="/assets/img/flags/4x3/mm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PA') ?>"><img src="/assets/img/flags/4x3/pa.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NU') ?>"><img src="/assets/img/flags/4x3/nu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MY') ?>"><img src="/assets/img/flags/4x3/my.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PG') ?>"><img src="/assets/img/flags/4x3/pg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LT') ?>"><img src="/assets/img/flags/4x3/lt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ID') ?>"><img src="/assets/img/flags/4x3/id.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MG') ?>"><img src="/assets/img/flags/4x3/mg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AO') ?>"><img src="/assets/img/flags/4x3/ao.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LB') ?>"><img src="/assets/img/flags/4x3/lb.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IE') ?>"><img src="/assets/img/flags/4x3/ie.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'UZ') ?>"><img src="/assets/img/flags/4x3/uz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KR') ?>"><img src="/assets/img/flags/4x3/kr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AD') ?>"><img src="/assets/img/flags/4x3/ad.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ME') ?>"><img src="/assets/img/flags/4x3/me.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MD') ?>"><img src="/assets/img/flags/4x3/md.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KP') ?>"><img src="/assets/img/flags/4x3/kp.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GY') ?>"><img src="/assets/img/flags/4x3/gy.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LA') ?>"><img src="/assets/img/flags/4x3/la.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MZ') ?>"><img src="/assets/img/flags/4x3/mz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LK') ?>"><img src="/assets/img/flags/4x3/lk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VN') ?>"><img src="/assets/img/flags/4x3/vn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MK') ?>"><img src="/assets/img/flags/4x3/mk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TT') ?>"><img src="/assets/img/flags/4x3/tt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TZ') ?>"><img src="/assets/img/flags/4x3/tz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MN') ?>"><img src="/assets/img/flags/4x3/mn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BY') ?>"><img src="/assets/img/flags/4x3/by.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CV') ?>"><img src="/assets/img/flags/4x3/cv.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TG') ?>"><img src="/assets/img/flags/4x3/tg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KE') ?>"><img src="/assets/img/flags/4x3/ke.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MT') ?>"><img src="/assets/img/flags/4x3/mt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SB') ?>"><img src="/assets/img/flags/4x3/sb.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CK') ?>"><img src="/assets/img/flags/4x3/ck.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SS') ?>"><img src="/assets/img/flags/4x3/ss.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DO') ?>"><img src="/assets/img/flags/4x3/do.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FJ') ?>"><img src="/assets/img/flags/4x3/fj.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CF') ?>"><img src="/assets/img/flags/4x3/cf.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TW') ?>"><img src="/assets/img/flags/4x3/tw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GW') ?>"><img src="/assets/img/flags/4x3/gw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NP') ?>"><img src="/assets/img/flags/4x3/np.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SO') ?>"><img src="/assets/img/flags/4x3/so.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AL') ?>"><img src="/assets/img/flags/4x3/al.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CZ') ?>"><img src="/assets/img/flags/4x3/cz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MW') ?>"><img src="/assets/img/flags/4x3/mw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LI') ?>"><img src="/assets/img/flags/4x3/li.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BN') ?>"><img src="/assets/img/flags/4x3/bn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BF') ?>"><img src="/assets/img/flags/4x3/bf.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BA') ?>"><img src="/assets/img/flags/4x3/ba.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GM') ?>"><img src="/assets/img/flags/4x3/gm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KH') ?>"><img src="/assets/img/flags/4x3/kh.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SK') ?>"><img src="/assets/img/flags/4x3/sk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LR') ?>"><img src="/assets/img/flags/4x3/lr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BD') ?>"><img src="/assets/img/flags/4x3/bd.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LU') ?>"><img src="/assets/img/flags/4x3/lu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GP') ?>"><img src="/assets/img/flags/4x3/gp.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KN') ?>"><img src="/assets/img/flags/4x3/kn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HR') ?>"><img src="/assets/img/flags/4x3/hr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ZW') ?>"><img src="/assets/img/flags/4x3/zw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BZ') ?>"><img src="/assets/img/flags/4x3/bz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HT') ?>"><img src="/assets/img/flags/4x3/ht.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NA') ?>"><img src="/assets/img/flags/4x3/na.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GN') ?>"><img src="/assets/img/flags/4x3/gn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GA') ?>"><img src="/assets/img/flags/4x3/ga.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NI') ?>"><img src="/assets/img/flags/4x3/ni.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JM') ?>"><img src="/assets/img/flags/4x3/jm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SL') ?>"><img src="/assets/img/flags/4x3/sl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SE') ?>"><img src="/assets/img/flags/4x3/se.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CG') ?>"><img src="/assets/img/flags/4x3/cg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XK') ?>"><img src="/assets/img/flags/4x3/xk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BB') ?>"><img src="/assets/img/flags/4x3/bb.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HN') ?>"><img src="/assets/img/flags/4x3/hn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BI') ?>"><img src="/assets/img/flags/4x3/bi.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RW') ?>"><img src="/assets/img/flags/4x3/rw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LS') ?>"><img src="/assets/img/flags/4x3/ls.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MU') ?>"><img src="/assets/img/flags/4x3/mu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MP') ?>"><img src="/assets/img/flags/4x3/mp.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'LC') ?>"><img src="/assets/img/flags/4x3/lc.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GF') ?>"><img src="/assets/img/flags/4x3/gf.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ZM') ?>"><img src="/assets/img/flags/4x3/zm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FM') ?>"><img src="/assets/img/flags/4x3/fm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BT') ?>"><img src="/assets/img/flags/4x3/bt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SN') ?>"><img src="/assets/img/flags/4x3/sn.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MV') ?>"><img src="/assets/img/flags/4x3/mv.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'IM') ?>"><img src="/assets/img/flags/4x3/im.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SH') ?>"><img src="/assets/img/flags/4x3/sh.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FO') ?>"><img src="/assets/img/flags/4x3/fo.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'EE') ?>"><img src="/assets/img/flags/4x3/ee.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CX') ?>"><img src="/assets/img/flags/4x3/cx.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KM') ?>"><img src="/assets/img/flags/4x3/km.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MQ') ?>"><img src="/assets/img/flags/4x3/mq.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BW') ?>"><img src="/assets/img/flags/4x3/bw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BS') ?>"><img src="/assets/img/flags/4x3/bs.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TV') ?>"><img src="/assets/img/flags/4x3/tv.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XG') ?>"><img src="/assets/img/flags/4x3/xg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KY') ?>"><img src="/assets/img/flags/4x3/ky.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GI') ?>"><img src="/assets/img/flags/4x3/gi.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TC') ?>"><img src="/assets/img/flags/4x3/tc.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GS') ?>"><img src="/assets/img/flags/4x3/gs.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BL') ?>"><img src="/assets/img/flags/4x3/bl.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GU') ?>"><img src="/assets/img/flags/4x3/gu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'BM') ?>"><img src="/assets/img/flags/4x3/bm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SZ') ?>"><img src="/assets/img/flags/4x3/sz.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'HK') ?>"><img src="/assets/img/flags/4x3/hk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VU') ?>"><img src="/assets/img/flags/4x3/vu.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VC') ?>"><img src="/assets/img/flags/4x3/vc.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'NC') ?>"><img src="/assets/img/flags/4x3/nc.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PW') ?>"><img src="/assets/img/flags/4x3/pw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'WF') ?>"><img src="/assets/img/flags/4x3/wf.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'XR') ?>"><img src="/assets/img/flags/4x3/xr.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MO') ?>"><img src="/assets/img/flags/4x3/mo.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MH') ?>"><img src="/assets/img/flags/4x3/mh.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'YT') ?>"><img src="/assets/img/flags/4x3/yt.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MF') ?>"><img src="/assets/img/flags/4x3/mf.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'MC') ?>"><img src="/assets/img/flags/4x3/mc.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'TO') ?>"><img src="/assets/img/flags/4x3/to.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'ST') ?>"><img src="/assets/img/flags/4x3/st.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AW') ?>"><img src="/assets/img/flags/4x3/aw.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AS') ?>"><img src="/assets/img/flags/4x3/as.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PF') ?>"><img src="/assets/img/flags/4x3/pf.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SX') ?>"><img src="/assets/img/flags/4x3/sx.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VG') ?>"><img src="/assets/img/flags/4x3/vg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'DM') ?>"><img src="/assets/img/flags/4x3/dm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'GD') ?>"><img src="/assets/img/flags/4x3/gd.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'JE') ?>"><img src="/assets/img/flags/4x3/je.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AG') ?>"><img src="/assets/img/flags/4x3/ag.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'RE') ?>"><img src="/assets/img/flags/4x3/re.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'PM') ?>"><img src="/assets/img/flags/4x3/pm.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'SG') ?>"><img src="/assets/img/flags/4x3/sg.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'FK') ?>"><img src="/assets/img/flags/4x3/fk.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'KI') ?>"><img src="/assets/img/flags/4x3/ki.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'AI') ?>"><img src="/assets/img/flags/4x3/ai.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'VA') ?>"><img src="/assets/img/flags/4x3/va.svg" width="30" /></a>
        <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, 'CW') ?>"><img src="/assets/img/flags/4x3/cw.svg" width="30" /></a>
    </div>
    


    <div>
        <div class="container" style="top: 20%">
            <div class="copy-text" style="margin-bottom: 10px;">
                <input id="greet" type="text" class="text" value="<?= $greet . ' ' . $geoLocation['city']; ?>." />
                <button><i class="fa fa-clone"></i></button>
            </div>
            <a href="<?= UrlHelper::getFullUrl($forceLunchGreet, $countryCode) ?>" style="color: white;padding: 4px;">Refresh</a>
        </div>
    </div>

    <iframe width="100%" height="600" src="https://www.google.com/maps/embed/v1/view?key=AIzaSyC_DQVcC5Tg6tdX3J4Wmah9GQiuHNd3yIQ&center=<?= $geoLocation['lat'] . ',' . $geoLocation['lng'] ?>&zoom=16&maptype=satellite"></iframe>

    
    <script src="/assets/js/script.js?v=0.023"></script>

</body>

</html>