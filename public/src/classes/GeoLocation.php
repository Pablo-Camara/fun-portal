<?php
require_once './Database.php';

class GeoLocation {

    /**
     * Gets a geolocation by its ID in the geolocation table
     *
     * @param int $id
     * @return mixed
     */
    public static function getById($id){
        $conn = Database::getNewPDOConnection();
        $sql = 'SELECT id,city,lat,lng FROM geolocation WHERE id = ? LIMIT 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    public static function getRandomGeoLocation(
        ?string $countryCode = null
    ){
        $conn = Database::getNewPDOConnection();
        $sql = 'SELECT id,city,lat,lng FROM geolocation';
        if (!is_null($countryCode) && preg_match('/^[a-zA-Z]{2}$/', $countryCode)) {
            $countryCode = strtoupper($countryCode);

            $sql .= ' WHERE iso2 = \'' . $countryCode . '\'';
        }
        $sql .= ' ORDER BY RAND() LIMIT 1';
        $rows = [];
        foreach ($conn->query($sql) as $row) {
            $rows[] = $row;
        };
    
        return $rows[0];
    }
}