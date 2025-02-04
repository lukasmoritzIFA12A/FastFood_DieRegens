<?php

namespace Repositories;

use Entitäten\Energiewert;

include 'datenbank/Repositories/DatenbankRepository.php';

class EnergiewertRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Energiewert
    {
        $sql = $this->getStatement()['SELECT_ENERGIEWERT_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Energiewert(
                $row['idEnergiewert'],
                $row['Produkt_idProdukt'],
                $row['PortionSize'],
                $row['Kalorien'],
                $row['Fett'],
                $row['Kohlenhydrate'],
                $row['Zucker'],
                $row['Eiweiss'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_ENERGIEWERT'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Energiewert(
                $row['idEnergiewert'],
                $row['Produkt_idProdukt'],
                $row['PortionSize'],
                $row['Kalorien'],
                $row['Fett'],
                $row['Kohlenhydrate'],
                $row['Zucker'],
                $row['Eiweiss'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}