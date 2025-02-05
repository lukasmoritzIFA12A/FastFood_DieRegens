<?php

namespace Entitaeten;

class Produkt_Zutat
{
    private int $Produkt_idProdukt;
    private int $Zutat_idZutat;

    public function __construct(int $Produkt_idProdukt, int $Zutat_idZutat)
    {
        $this->Produkt_idProdukt = $Produkt_idProdukt;
        $this->Zutat_idZutat = $Zutat_idZutat;
    }

    public function getProduktIdProdukt(): int
    {
        return $this->Produkt_idProdukt;
    }

    public function setProduktIdProdukt(int $Produkt_idProdukt): void
    {
        $this->Produkt_idProdukt = $Produkt_idProdukt;
    }

    public function getZutatIdZutat(): int
    {
        return $this->Zutat_idZutat;
    }

    public function setZutatIdZutat(int $Zutat_idZutat): void
    {
        $this->Zutat_idZutat = $Zutat_idZutat;
    }
}