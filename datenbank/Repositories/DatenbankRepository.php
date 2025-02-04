<?php

namespace Repositories;

abstract class DatenbankRepository
{
    private $stmnt;
    private $conn;

    function __construct($conn)
    {
        $this->stmnt = include('datenbank/Statements/SQLStatements.php');
        $this->conn = $conn;
    }

    public function getStatement()
    {
        return $this->stmnt;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    abstract function getById($id);

    abstract function getAll();
}