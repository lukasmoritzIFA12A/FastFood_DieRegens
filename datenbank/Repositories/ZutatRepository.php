<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Zutat;

class ZutatRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Zutat
    {
        $sql = $this->getStatement()['SELECT_ZUTAT_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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