<?php

namespace Entitaeten;

class Contest
{
    private int $idContest;
    private string $bild; //BLOB
    private int $Bestellung_idBestellung;
    private bool $freigeschalten = false;

    public function __construct(int $idContest, string $bild, int $Bestellung_idBestellung, bool $freigeschalten)
    {
        $this->idContest = $idContest;
        $this->bild = $bild;
        $this->Bestellung_idBestellung = $Bestellung_idBestellung;
        $this->freigeschalten = $freigeschalten;
    }

    public function getIdContest(): int
    {
        return $this->idContest;
    }

    public function setIdContest(int $idContest): void
    {
        $this->idContest = $idContest;
    }

    public function getBestellungIdBestellung(): int
    {
        return $this->Bestellung_idBestellung;
    }

    public function setBestellungIdBestellung(int $Bestellung_idBestellung): void
    {
        $this->Bestellung_idBestellung = $Bestellung_idBestellung;
    }

    public function getBild(): string
    {
        return $this->bild;
    }

    public function setBild(string $bild): void
    {
        $this->bild = $bild;
    }

    public function isFreigeschalten(): bool
    {
        return $this->freigeschalten;
    }

    public function setFreigeschalten(bool $freigeschalten): void
    {
        $this->freigeschalten = $freigeschalten;
    }
}