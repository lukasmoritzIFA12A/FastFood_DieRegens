<?php

abstract class DatenbankRepository
{
    private $stmnt;
    private mysqli $conn;

    function __construct($conn)
    {
        $this->stmnt = include('datenbank/Statements/SQLStatements.php');
        $this->conn = $conn;
    }

    public function getStatement()
    {
        return $this->stmnt;
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    function getResultFromPreparedStatementById(string $statement, int $id) {
        $stmt = $this->getConnection()->prepare($statement);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        return $stmt->get_result();
    }

    abstract function getById($id);

    abstract function getAll();
}