<?php
namespace Entitäten;

class Adresse
{
    private int $idAdresse;
    private string $Strassenname;
    private string $Hausnummer;
    private ?string $Zusatz;
    private string $PLZ;
    private string $Stadt;
    private string $Bundesland;

    public function __construct(int $idAdresse, string $Strassenname, string $Hausnummer, ?string $Zusatz, string $PLZ, string $Stadt, string $Bundesland)
    {
        $this->idAdresse = $idAdresse;
        $this->Strassenname = $Strassenname;
        $this->Hausnummer = $Hausnummer;
        $this->Zusatz = $Zusatz;
        $this->PLZ = $PLZ;
        $this->Stadt = $Stadt;
        $this->Bundesland = $Bundesland;
    }

    public function getIdAdresse(): int
    {
        return $this->idAdresse;
    }

    public function setIdAdresse(int $idAdresse): void
    {
        $this->idAdresse = $idAdresse;
    }

    public function getBundesland(): string
    {
        return $this->Bundesland;
    }

    public function setBundesland(string $Bundesland): void
    {
        $this->Bundesland = $Bundesland;
    }

    public function getStadt(): string
    {
        return $this->Stadt;
    }

    public function setStadt(string $Stadt): void
    {
        $this->Stadt = $Stadt;
    }

    public function getZusatz(): ?string
    {
        return $this->Zusatz;
    }

    public function setZusatz(?string $Zusatz): void
    {
        $this->Zusatz = $Zusatz;
    }

    public function getPLZ(): string
    {
        return $this->PLZ;
    }

    public function setPLZ(string $PLZ): void
    {
        $this->PLZ = $PLZ;
    }

    public function getHausnummer(): string
    {
        return $this->Hausnummer;
    }

    public function setHausnummer(string $Hausnummer): void
    {
        $this->Hausnummer = $Hausnummer;
    }

    public function getStrassenname(): string
    {
        return $this->Strassenname;
    }

    public function setStrassenname(string $Strassenname): void
    {
        $this->Strassenname = $Strassenname;
    }
}