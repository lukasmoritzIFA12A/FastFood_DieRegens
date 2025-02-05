<?php

namespace Entitaeten;

class Zahlungsart
{
    private int $idZahlungsart;
    private string $Art;

    public function __construct(int $idZahlungsart, string $Art)
    {
        $this->idZahlungsart = $idZahlungsart;
        $this->Art = $Art;
    }

    public function getIdZahlungsart(): int
    {
        return $this->idZahlungsart;
    }

    public function setIdZahlungsart(int $idZahlungsart): void
    {
        $this->idZahlungsart = $idZahlungsart;
    }

    public function getArt(): string
    {
        return $this->Art;
    }

    public function setArt(string $Art): void
    {
        $this->Art = $Art;
    }
}