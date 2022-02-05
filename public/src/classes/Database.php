<?php


class Database {


    /**
     * Returns a new PDO Connection with some attributes already set
     *
     * @return PDO
     */
    public static function getNewPDOConnection(){
        $conn = new PDO("mysql:host=db-mysql-fra1-10014-do-user-10634055-0.b.db.ondigitalocean.com:25060;dbname=defaultdb", "doadmin", "3SCXIcZS82Fs0Mns");

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}