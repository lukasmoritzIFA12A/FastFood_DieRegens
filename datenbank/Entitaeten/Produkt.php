<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Produkt extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getTitel(): string
    {
        return $this->getBean()->getProperties()['Titel'];
    }

    public function setTitel(string $Titel): void
    {
        $this->getBean()->titel = $Titel;
    }

    public function getIconId(): int
    {
        return $this->getBean()->getProperties()['Icon_id'];
    }

    public function setIconId(int $Icon_id): void
    {
        $this->getBean()->icon_id = $Icon_id;
    }

    public function getBeschreibung(): ?string
    {
        return $this->getBean()->getProperties()['Beschreibung'];
    }

    public function setBeschreibung(?string $Beschreibung): void
    {
        $this->getBean()->beschreibung = $Beschreibung;
    }

    public function getPreis(): string
    {
        return $this->getBean()->getProperties()['Preis'];
    }

    public function setPreis(string $Preis): void
    {
        $this->getBean()->preis = $Preis;
    }

    public function getLagerbestand(): int
    {
        return $this->getBean()->getProperties()['Lagerbestand'];
    }

    public function setLagerbestand(int $Lagerbestand): void
    {
        $this->getBean()->lagerbestand = $Lagerbestand;
    }

    public function getRabatt(): ?string
    {
        return $this->getBean()->getProperties()['Rabatt'];
    }

    public function setRabatt(?string $Rabatt): void
    {
        $this->getBean()->rabatt = $Rabatt;
    }
}