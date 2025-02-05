<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Contest;

class ContestRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Contest
    {
        $sql = $this->getStatement()['SELECT_CONTEST_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

        if ($row = $result->fetch_assoc()) {
            return new Contest(
                $row['idContest'],
                $row['bild'],
                $row['Bestellung_idBestellung'],
                $row['freigeschalten']
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_CONTEST'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Contest(
                $row['idContest'],
                $row['bild'],
                $row['Bestellung_idBestellung'],
                $row['freigeschalten']
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}