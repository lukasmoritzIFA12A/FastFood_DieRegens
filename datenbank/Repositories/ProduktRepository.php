<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Produkt;

class ProduktRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Produkt
    {
        $sql = $this->getStatement()['SELECT_PRODUKT_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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