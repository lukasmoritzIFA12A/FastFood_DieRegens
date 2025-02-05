<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Bestellung;

class BestellungRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Bestellung
    {
        $sql = $this->getStatement()['SELECT_BESTELLUNG_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

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