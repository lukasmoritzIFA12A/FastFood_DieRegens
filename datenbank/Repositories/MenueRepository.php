<?php

namespace Repositories;

use Entitäten\Menue;

include 'datenbank/Repositories/DatenbankRepository.php';

class MenueRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Menue
    {
        $sql = $this->getStatement()['SELECT_MENUE_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Menue(
                $row['idMenue'],
                $row['Titel'],
                $row['Beschreibung'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_MENUE'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Menue(
                $row['idMenue'],
                $row['Titel'],
                $row['Beschreibung'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}