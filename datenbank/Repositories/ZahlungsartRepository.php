<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Zahlungsart;

class ZahlungsartRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Zahlungsart
    {
        $sql = $this->getStatement()['SELECT_ZAHLUNGSART_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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