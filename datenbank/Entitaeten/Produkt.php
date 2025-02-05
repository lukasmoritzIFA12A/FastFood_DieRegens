<?php

namespace Entitaeten;

class Produkt
{
    private int $idProdukt;
    private int $Icon_idIcon;
    private string $Titel;
    private ?string $Beschreibung;
    private string $Preis; //kein float wegen rundungsfehlern!
    private int $Lagerbestand;
    private ?string $Rabatt; //kein float wegen rundungsfehlern!

    public function __construct(int $idProdukt, int $Icon_idIcon, string $Titel, string $Preis, ?string $Beschreibung, int $Lagerbestand, ?string $Rabatt)
    {
        $this->idProdukt = $idProdukt;
        $this->Icon_idIcon = $Icon_idIcon;
        $this->Titel = $Titel;
        $this->Preis = $Preis;
        $this->Beschreibung = $Beschreibung;
        $this->Lagerbestand = $Lagerbestand;
        $this->Rabatt = $Rabatt;
    }

    public function getIdProdukt(): int
    {
        return $this->idProdukt;
    }

    public function setIdProdukt(int $idProdukt): void
    {
        $this->idProdukt = $idProdukt;
    }

    public function getTitel(): string
    {
        return $this->Titel;
    }

    public function setTitel(string $Titel): void
    {
        $this->Titel = $Titel;
    }

    public function getIconIdIcon(): int
    {
        return $this->Icon_idIcon;
    }

    public function setIconIdIcon(int $Icon_idIcon): void
    {
        $this->Icon_idIcon = $Icon_idIcon;
    }

    public function getBeschreibung(): ?string
    {
        return $this->Beschreibung;
    }

    public function setBeschreibung(?string $Beschreibung): void
    {
        $this->Beschreibung = $Beschreibung;
    }

    public function getPreis(): string
    {
        return $this->Preis;
    }

    public function setPreis(string $Preis): void
    {
        $this->Preis = $Preis;
    }

    public function getLagerbestand(): int
    {
        return $this->Lagerbestand;
    }

    public function setLagerbestand(int $Lagerbestand): void
    {
        $this->Lagerbestand = $Lagerbestand;
    }

    public function getRabatt(): ?string
    {
        return $this->Rabatt;
    }

    public function setRabatt(?string $Rabatt): void
    {
        $this->Rabatt = $Rabatt;
    }
}