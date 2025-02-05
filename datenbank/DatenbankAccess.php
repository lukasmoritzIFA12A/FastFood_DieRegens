<?php

class DatenbankAccess
{
    protected mysqli $conn;
    protected $configs;

    function __construct() {
        $this->configs = include('Config.php');

        $this->conn = new mysqli(
            $this->configs['servername'],
            $this->configs['username'],
            $this->configs['password'],
            $this->configs['dbname']
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connected successfully"."<br>";
    }

    function __destruct() {
        $this->conn->close();
    }

    function getConnection(): mysqli {
        return $this->conn;
    }
}