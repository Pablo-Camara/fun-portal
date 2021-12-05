<?php


class Database {


    /**
     * Returns a new PDO Connection with some attributes already set
     *
     * @return PDO
     */
    public static function getNewPDOConnection(){
        $conn = new PDO("mysql:host=www-do-user-10001768-0.b.db.ondigitalocean.com:25060;dbname=defaultdb", "doadmin", "o2jsBVd23Q5y7Pgo");

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}