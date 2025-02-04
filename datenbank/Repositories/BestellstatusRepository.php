<?php

namespace Repositories;

use Entitäten\Bestellstatus;

include 'datenbank/Repositories/DatenbankRepository.php';

class BestellstatusRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Bestellstatus
    {
        $sql = $this->getStatement()['SELECT_BESTELLSTATUS_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Bestellstatus(
                $row['idBestellstatus'],
                $row['status'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_BESTELLSTATUS'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Bestellstatus(
                $row['idBestellstatus'],
                $row['status'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}