<?php

namespace Repositories;

use Entitäten\Login;

include 'datenbank/Repositories/DatenbankRepository.php';

class LoginRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Login
    {
        $sql = $this->getStatement()['SELECT_LOGIN_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Login(
                $row['idLogin'],
                $row['Nutzername'],
                $row['Passwort'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_LOGIN'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Login(
                $row['idLogin'],
                $row['Nutzername'],
                $row['Passwort'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}