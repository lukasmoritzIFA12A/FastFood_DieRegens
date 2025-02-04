<?php

namespace Repositories;

use Entitäten\Produkt;

include 'datenbank/Repositories/DatenbankRepository.php';

class ProduktRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Produkt
    {
        $sql = $this->getStatement()['SELECT_PRODUKT_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Produkt(
                $row['idProdukt'],
                $row['Icon_idIcon'],
                $row['Titel'],
                $row['Beschreibung'],
                $row['Preis'],
                $row['Lagerbestand'],
                $row['Rabatt'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_PRODUKT'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Produkt(
                $row['idProdukt'],
                $row['Icon_idIcon'],
                $row['Titel'],
                $row['Beschreibung'],
                $row['Preis'],
                $row['Lagerbestand'],
                $row['Rabatt'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}