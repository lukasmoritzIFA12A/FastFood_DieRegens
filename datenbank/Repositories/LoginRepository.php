<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Login;

class LoginRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Login
    {
        $sql = $this->getStatement()['SELECT_LOGIN_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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