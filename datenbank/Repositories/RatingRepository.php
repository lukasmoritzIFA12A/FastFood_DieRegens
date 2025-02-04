<?php

namespace Repositories;

use Entitäten\Rating;

include 'datenbank/Repositories/DatenbankRepository.php';

class RatingRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Rating
    {
        $sql = $this->getStatement()['SELECT_RATING_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Rating(
                $row['idRating'],
                $row['Kunde_idKunde'],
                $row['Contest_idContest'],
                $row['Rating'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_RATING'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Rating(
                $row['idRating'],
                $row['Kunde_idKunde'],
                $row['Contest_idContest'],
                $row['Rating'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}