<?php

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','12345678');
define('DB_DATABASE','balticsamurai');

class DatabaseConnection
{
    public function __construct()
    {
        $conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE);

        if($conn->connect_error)
        {
            die ("<h1>Database Connection Failed</h1>");
        }
        
        return $this->conn = $conn;
    }
}
