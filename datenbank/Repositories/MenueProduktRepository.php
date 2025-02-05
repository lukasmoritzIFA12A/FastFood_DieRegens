<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Menue_Produkt;

class MenueProduktRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getAllByMenueId($menueId): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_PRODUKT_VON_MENUEID'];
        $result = $this->getResultFromPreparedStatementById($sql, $menueId);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Menue_Produkt(
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

    function getAllByProduktId($produktId): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_MENUE_VON_PRODUKTID'];
        $result = $this->getResultFromPreparedStatementById($sql, $produktId);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Menue_Produkt(
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

    function getById($id): ?Menue_Produkt
    {
        return null;
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_MENUE_PRODUKT'];
        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Menue_Produkt(
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
}