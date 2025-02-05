<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Produkt_Zutat;

class ProduktZutatRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Produkt_Zutat
    {
        return null;
    }

    function getAllProduktByZutatId($zutatId): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_PRODUKT_VON_ZUTATID'];
        $result = $this->getResultFromPreparedStatementById($sql, $zutatId);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Produkt_Zutat(
                $row['Menue_idMenue'],
                $row['Produkt_idProdukt'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }

    function getAllZutatByProduktId($produktId): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_ZUTAT_VON_PRODUKTID'];
        $result = $this->getResultFromPreparedStatementById($sql, $produktId);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Produkt_Zutat(
                $row['Menue_idMenue'],
                $row['Produkt_idProdukt'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_PRODUKT_UND_ZUTAT'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Produkt_Zutat(
                $row['Produkt_idProdukt'],
                $row['Zutat_idZutat'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}