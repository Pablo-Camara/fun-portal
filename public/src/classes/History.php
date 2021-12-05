<?php
require_once 'Database.php';

class History {

    /**
     * Stores GeoLocation ID and IP in the history table
     *
     * @param int $geoLocationId
     * @param string $userIP
     * @return bool
     */
    public static function storeGeoLocationHistory($geoLocationId, $userIP){
        $conn = Database::getNewPDOConnection();
        $sql = "INSERT INTO history (geolocation_id, ip) VALUES (?,?)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([$geoLocationId, $userIP]);
    }
}