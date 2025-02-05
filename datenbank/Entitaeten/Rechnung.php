<?php

namespace Entitaeten;

use DateTime;

class Rechnung
{
    private int $idRechnung;
    private int $Bestellung_idBestellung;
    private DateTime $ZahlungsDatum;
    private int $Rabatt_idRabatt;

    public function __construct(int $idRechnung, int $Bestellung_idBestellung, DateTime $ZahlungsDatum, int $Rabatt_idRabatt)
    {
        $this->idRechnung = $idRechnung;
        $this->Bestellung_idBestellung = $Bestellung_idBestellung;
        $this->ZahlungsDatum = $ZahlungsDatum;
        $this->Rabatt_idRabatt = $Rabatt_idRabatt;
    }

    public function getIdRechnung(): int
    {
        return $this->idRechnung;
    }

    public function setIdRechnung(int $idRechnung): void
    {
        $this->idRechnung = $idRechnung;
    }

    public function getBestellungIdBestellung(): int
    {
        return $this->Bestellung_idBestellung;
    }

    public function setBestellungIdBestellung(int $Bestellung_idBestellung): void
    {
        $this->Bestellung_idBestellung = $Bestellung_idBestellung;
    }

    public function getZahlungsDatum(): DateTime
    {
        return $this->ZahlungsDatum;
    }

    public function setZahlungsDatum(DateTime $ZahlungsDatum): void
    {
        $this->ZahlungsDatum = $ZahlungsDatum;
    }

    public function getRabattIdRabatt(): int
    {
        return $this->Rabatt_idRabatt;
    }

    public function setRabattIdRabatt(int $Rabatt_idRabatt): void
    {
        $this->Rabatt_idRabatt = $Rabatt_idRabatt;
    }
}