<?php

namespace Repositories;

use Entitäten\Bestellung;

include 'datenbank/Repositories/DatenbankRepository.php';

class BestellungRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Bestellung
    {
        $sql = $this->getStatement()['SELECT_BESTELLUNG_BY_ID'];

        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_Param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Bestellung(
                $row['idBestellung'],
                $row['BestellungDatum'],
                $row['Kunde_idKunde'],
                $row['Zahlungsart_idZahlungsart'],
                $row['Produkt_idProdukt'],
                $row['Menue_idMenue'],
                $row['Bestellstatus_idBestellstatus'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_BESTELLUNG'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Bestellung(
                $row['idBestellung'],
                $row['BestellungDatum'],
                $row['Kunde_idKunde'],
                $row['Zahlungsart_idZahlungsart'],
                $row['Produkt_idProdukt'],
                $row['Menue_idMenue'],
                $row['Bestellstatus_idBestellstatus'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}