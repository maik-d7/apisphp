<?php

// CONECCION POR MYSQLI

// $mysql = new mysqli(
//     "bmpyqzw9r99syb4pdrhj-mysql.services.clever-cloud.com",
//     "ubcomlx0alnyfg3y",
//     "70GOx03nWasXaFNV8saW",
//     "bmpyqzw9r99syb4pdrhj"
// );

// if ($mysql->connect_error) {
//     die("Failed to connect" . $mysql->connect_error);
// }


// CONECCION POR PDO

class Database {
    // variable coneccion cuenta perdida perdida de clever cloud papito
    // private $host = "bmpyqzw9r99syb4pdrhj-mysql.services.clever-cloud.com";
    // private $db_name = "bmpyqzw9r99syb4pdrhj";
    // private $username = "ubcomlx0alnyfg3y";
    // private $password = "70GOx03nWasXaFNV8saW";

    // variables de conceccion 
    private $host = "sfo1.clusters.zeabur.com";
    private $db_name = "monito";
    private $username = "root";
    private $password = "9Xc5Gjv2ORp7d04byf6183wgWZuLeQEk";
    private $port = 32635;


    public $conn;

    // Función para obtener la conexión
    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}