<?php

namespace Entitaeten;

class Energiewert
{
    private int $idEnergiewert;
    private int $Produkt_idProdukt;
    private ?string $PortionSize;
    private ?string $Kalorien; //kein float wegen rundungsfehlern!
    private ?string $Fett; //kein float wegen rundungsfehlern!
    private ?string $Kohlenhydrate; //kein float wegen rundungsfehlern!
    private ?string $Zucker; //kein float wegen rundungsfehlern!
    private ?string $Eiweiss; //kein float wegen rundungsfehlern!

    public function __construct(int $idEnergiewert, int $Produkt_idProdukt, ?string $PortionSize, ?string $Kalorien, ?string $Fett, ?string $Kohlenhydrate, ?string $Zucker, ?string $Eiweiss)
    {
        $this->idEnergiewert = $idEnergiewert;
        $this->Produkt_idProdukt = $Produkt_idProdukt;
        $this->PortionSize = $PortionSize;
        $this->Kalorien = $Kalorien;
        $this->Fett = $Fett;
        $this->Kohlenhydrate = $Kohlenhydrate;
        $this->Zucker = $Zucker;
        $this->Eiweiss = $Eiweiss;
    }

    public function getIdEnergiewert(): int
    {
        return $this->idEnergiewert;
    }

    public function setIdEnergiewert(int $idEnergiewert): void
    {
        $this->idEnergiewert = $idEnergiewert;
    }

    public function getPortionSize(): ?string
    {
        return $this->PortionSize;
    }

    public function setPortionSize(?string $PortionSize): void
    {
        $this->PortionSize = $PortionSize;
    }

    public function getProduktIdProdukt(): int
    {
        return $this->Produkt_idProdukt;
    }

    public function setProduktIdProdukt(int $Produkt_idProdukt): void
    {
        $this->Produkt_idProdukt = $Produkt_idProdukt;
    }

    public function getKalorien(): ?string
    {
        return $this->Kalorien;
    }

    public function setKalorien(?string $Kalorien): void
    {
        $this->Kalorien = $Kalorien;
    }

    public function getFett(): ?string
    {
        return $this->Fett;
    }

    public function setFett(?string $Fett): void
    {
        $this->Fett = $Fett;
    }

    public function getKohlenhydrate(): ?string
    {
        return $this->Kohlenhydrate;
    }

    public function setKohlenhydrate(?string $Kohlenhydrate): void
    {
        $this->Kohlenhydrate = $Kohlenhydrate;
    }

    public function getZucker(): ?string
    {
        return $this->Zucker;
    }

    public function setZucker(?string $Zucker): void
    {
        $this->Zucker = $Zucker;
    }

    public function getEiweiss(): ?string
    {
        return $this->Eiweiss;
    }

    public function setEiweiss(?string $Eiweiss): void
    {
        $this->Eiweiss = $Eiweiss;
    }
}