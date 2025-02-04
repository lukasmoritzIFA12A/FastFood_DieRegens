<?php

namespace Repositories;

use Entitäten\Contest;

include 'datenbank/Repositories/DatenbankRepository.php';

class ContestRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Contest
    {
        $sql = $this->getStatement()['SELECT_CONTEST_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Contest(
                $row['idContest'],
                $row['bild'],
                $row['Bestellung_idBestellung'],
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
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}