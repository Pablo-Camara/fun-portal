<?php

class UrlHelper {

    public static function getFullUrl(
        bool $forceLunchGreet,
        ?string $countryCode = null,
        ?int $geoLocationId = null
    ){
        $domain = $_SERVER['SERVER_NAME'];

        $params = [];

        $params[] = !empty($geoLocationId) ? 'gid=' . $geoLocationId : '';
        $params[] = $forceLunchGreet ? 'l=1' : '';
        $params[] = !empty($countryCode) ? 'c=' . $countryCode : '';

        $params = array_filter($params, function($val){
            return !empty($val);
        });
        
        if (!empty($params)) {
            $domain .= '/?';

            foreach($params as $index => $param){
                if($index > 0){
                    $domain .= '&';
                }

                $domain .= $param;
            }
        }
        $domain = 'https://' . $domain;

        die($domain);
        return $domain;
    }
}