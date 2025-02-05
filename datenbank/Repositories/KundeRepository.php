<?php

namespace Repositories;

use DatenbankRepository;
use Entitaeten\Kunde;

class KundeRepository extends DatenbankRepository
{
    function __construct($conn)
    {
        parent::__construct($conn);
    }

    function getById($id): ?Kunde
    {
        $sql = $this->getStatement()['SELECT_KUNDE_BY_ID'];
        $result = $this->getResultFromPreparedStatementById($sql, $id);

        if ($row = $result->fetch_assoc()) {
            return new Kunde(
                $row['idKunde'],
                $row['Adresse_idAdresse'],
                $row['Vorname'],
                $row['Nachname'],
                $row['Telefonnummer'],
                $row['Registrierungsdatum'],
                $row['Login_idLogin'],
                $row['Kundenstatus_idKundenstatus'],
            );
        } else {
            return null;
        }
    }

    function getAll(): ?array
    {
        $sql = $this->getStatement()['SELECT_ALL_KUNDE'];

        $result = $this->getConnection()->query($sql);

        $resultArray = [];

        while ($row = $result->fetch_assoc()) {
            $resultArray[] = new Kunde(
                $row['idKunde'],
                $row['Adresse_idAdresse'],
                $row['Vorname'],
                $row['Nachname'],
                $row['Telefonnummer'],
                $row['Registrierungsdatum'],
                $row['Login_idLogin'],
                $row['Kundenstatus_idKundenstatus'],
            );
        }

        if (empty($resultArray)) {
            return null;
        } else {
            return $resultArray;
        }
    }
}