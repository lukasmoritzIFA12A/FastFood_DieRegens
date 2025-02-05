<?php

namespace Entitaeten;

class Menue_Produkt
{
    private int $Menue_idMenue;
    private int $Produkt_idProdukt;

    public function __construct(int $Menue_idMenue, int $Produkt_idProdukt)
    {
        $this->Menue_idMenue = $Menue_idMenue;
        $this->Produkt_idProdukt = $Produkt_idProdukt;
    }

    public function getMenueIdMenue(): int
    {
        return $this->Menue_idMenue;
    }

    public function setMenueIdMenue(int $Menue_idMenue): void
    {
        $this->Menue_idMenue = $Menue_idMenue;
    }

    public function getProduktIdProdukt(): int
    {
        return $this->Produkt_idProdukt;
    }

    public function setProduktIdProdukt(int $Produkt_idProdukt): void
    {
        $this->Produkt_idProdukt = $Produkt_idProdukt;
    }
}