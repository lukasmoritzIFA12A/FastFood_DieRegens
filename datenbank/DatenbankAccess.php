<?php

use RedBeanPHP\R;

class DatenbankAccess
{
    private array $configs;

    function __construct(?string $datenbankname)
    {
        $this->configs = include(dirname(__DIR__).'/datenbank/Config.php');

        if ($datenbankname) {
            $dbName = $datenbankname;
        } else {
            $dbName = $this->configs['dbname'];
        }

        R::setup('mysql:host='.$this->configs['servername'].';dbname='.$dbName, $this->configs['username'], $this->configs['password']);

        if (!R::testConnection()) {
            die("Fehler bei der Verbindung zur Datenbank");
        }

        R::freeze();

        echo "Connected successfully"."<br>";
    }

    function close(): void
    {
        R::close();
    }
}