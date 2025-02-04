<?php

namespace Repositories;

use Entitäten\Zutat;

include 'datenbank/Repositories/DatenbankRepository.php';

class ZutatRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Zutat
    {
        $sql = $this->getStatement()['SELECT_ZUTAT_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Zutat(
                $row['idZutat'],
                $row['ZutatName'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_ZUTAT'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Zutat(
                $row['idZutat'],
                $row['ZutatName'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}