<?php

namespace Repositories;

use Entitäten\Admin;

include 'datenbank/Repositories/DatenbankRepository.php';

class AdminRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Admin
    {
        return null;
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_ADMIN'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Admin(
                $row['Login_idLogin'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}