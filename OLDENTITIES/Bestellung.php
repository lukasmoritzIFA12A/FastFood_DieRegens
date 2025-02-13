<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Bestellung extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getBestellungDatum(): string
    {
        return $this->getBean()->getProperties()['BestellungDatum'];
    }

    public function setBestellungDatum(string $BestellungDatum): void
    {
        $this->getBean()->bestellungdatum = $BestellungDatum;
    }

    public function getKundeId(): int
    {
        return $this->getBean()->getProperties()['Kunde_id'];
    }

    public function setKundeId(int $Kunde_id): void
    {
        $this->getBean()->kunde_id = $Kunde_id;
    }

    public function getZahlungsartId(): int
    {
        return $this->getBean()->getProperties()['Zahlungsart_id'];
    }

    public function setZahlungsartId(int $Zahlungsart_id): void
    {
        $this->getBean()->zahlungsart_id = $Zahlungsart_id;
    }

    public function getBestellstatusId(): int
    {
        return $this->getBean()->getProperties()['Bestellstatus_id'];
    }

    public function setBestellstatusId(int $Bestellstatus_id): void
    {
        $this->getBean()->bestellstatus_id = $Bestellstatus_id;
    }
}