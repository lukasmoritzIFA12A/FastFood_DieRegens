<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Rechnung;

class RechnungRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Rechnung
    {
        $sql = $this->getStatement()['SELECT_RECHNUNG_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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