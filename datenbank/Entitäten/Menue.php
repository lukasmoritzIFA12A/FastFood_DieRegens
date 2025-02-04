<?php

namespace Entitäten;

class Menue
{
    private int $idMenue;
    private string $Titel;
    private ?string $Beschreibung;

    public function __construct(int $idMenue, string $Titel, ?string $Beschreibung)
    {
        $this->idMenue = $idMenue;
        $this->Titel = $Titel;
        $this->Beschreibung = $Beschreibung;
    }

    public function getIdMenue(): int
    {
        return $this->idMenue;
    }

    public function setIdMenue(int $idMenue): void
    {
        $this->idMenue = $idMenue;
    }

    public function getTitel(): string
    {
        return $this->Titel;
    }

    public function setTitel(string $Titel): void
    {
        $this->Titel = $Titel;
    }

    public function getBeschreibung(): ?string
    {
        return $this->Beschreibung;
    }

    public function setBeschreibung(?string $Beschreibung): void
    {
        $this->Beschreibung = $Beschreibung;
    }
}