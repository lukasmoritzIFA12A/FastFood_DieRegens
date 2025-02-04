<?php

namespace Repositories;

use Entitäten\Rechnung;

include 'datenbank/Repositories/DatenbankRepository.php';

class RechnungRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Rechnung
    {
        $sql = $this->getStatement()['SELECT_RECHNUNG_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Rechnung(
                $row['idRechnung'],
                $row['Bestellung_idBestellung'],
                $row['Zahlungsdatum'],
                $row['Rabatt_idRabatt'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_RECHNUNG'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Rechnung(
                $row['idRechnung'],
                $row['Bestellung_idBestellung'],
                $row['Zahlungsdatum'],
                $row['Rabatt_idRabatt'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}