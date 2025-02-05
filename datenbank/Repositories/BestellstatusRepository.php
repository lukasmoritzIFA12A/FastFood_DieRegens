<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Bestellstatus;

class BestellstatusRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Bestellstatus
    {
        $sql = $this->getStatement()['SELECT_BESTELLSTATUS_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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