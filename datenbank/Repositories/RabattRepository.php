<?php

namespace Repositories;

use Entitäten\Rabatt;

include 'datenbank/Repositories/DatenbankRepository.php';

class RabattRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Rabatt
    {
        $sql = $this->getStatement()['SELECT_RABATT_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Rabatt(
                $row['idRabatt'],
                $row['code'],
                $row['minderung'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_RABATT'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Rabatt(
                $row['idRabatt'],
                $row['code'],
                $row['minderung'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}