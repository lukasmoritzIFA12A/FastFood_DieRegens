<?php

namespace Repositories;

use Entitäten\Zahlungsart;

include 'datenbank/Repositories/DatenbankRepository.php';

class ZahlungsartRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Zahlungsart
    {
        $sql = $this->getStatement()['SELECT_ZAHLUNGSART_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Zahlungsart(
                $row['idZahlungsart'],
                $row['Art'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_ZAHLUNGSART'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Zahlungsart(
                $row['idZahlungsart'],
                $row['Art'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}