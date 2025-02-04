<?php

namespace Repositories;

include 'datenbank/Entitäten/Adresse.php';
include 'datenbank/Repositories/DatenbankRepository.php';
use Entitäten\Adresse;

class AdresseRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Adresse
    {
        $sql = $this->getStatement()['SELECT_ADRESSE_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Adresse(
                $row['idAdresse'],
                $row['Strassenname'],
                $row['Hausnummer'],
                $row['Zusatz'],
                $row['PLZ'],
                $row['Stadt'],
                $row['Bundesland']
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array {
        $sql = $this->getStatement()['SELECT_ALL_ADRESSE'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Adresse(
                $row['idAdresse'],
                $row['Strassenname'],
                $row['Hausnummer'],
                $row['Zusatz'],
                $row['PLZ'],
                $row['Stadt'],
                $row['Bundesland']
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}