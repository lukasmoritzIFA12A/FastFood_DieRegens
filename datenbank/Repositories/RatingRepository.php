<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Rating;

class RatingRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Rating
    {
        $sql = $this->getStatement()['SELECT_RATING_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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