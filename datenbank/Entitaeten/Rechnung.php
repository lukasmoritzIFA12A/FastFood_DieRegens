<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Rechnung extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getBestellungId(): int
    {
        return $this->getBean()->getProperties()['Bestellung_id'];
    }

    public function setBestellungId(int $Bestellung_id): void
    {
        $this->getBean()->bestellung_id = $Bestellung_id;
    }

    public function getZahlungsDatum(): string
    {
        return $this->getBean()->getProperties()['ZahlungsDatum'];
    }

    public function setZahlungsDatum(string $ZahlungsDatum): void
    {
        $this->getBean()->zahlungsdatum = $ZahlungsDatum;
    }

    public function getRabattId(): int
    {
        return $this->getBean()->getProperties()['Rabatt_id'];
    }

    public function setRabattId(?int $Rabatt_id): void
    {
        $this->getBean()->rabatt_id = $Rabatt_id;
    }
}