<?php

namespace Entitäten;

class Rating
{
    private int $idRating;
    private int $Kunde_idKunde;
    private int $Contest_idContest;
    private int $Rating;

    public function __construct(int $Kunde_idKunde, int $idRating, int $Contest_idContest, int $Rating)
    {
        $this->Kunde_idKunde = $Kunde_idKunde;
        $this->idRating = $idRating;
        $this->Contest_idContest = $Contest_idContest;
        $this->Rating = $Rating;
    }

    public function getIdRating(): int
    {
        return $this->idRating;
    }

    public function setIdRating(int $idRating): void
    {
        $this->idRating = $idRating;
    }

    public function getKundeIdKunde(): int
    {
        return $this->Kunde_idKunde;
    }

    public function setKundeIdKunde(int $Kunde_idKunde): void
    {
        $this->Kunde_idKunde = $Kunde_idKunde;
    }

    public function getContestIdContest(): int
    {
        return $this->Contest_idContest;
    }

    public function setContestIdContest(int $Contest_idContest): void
    {
        $this->Contest_idContest = $Contest_idContest;
    }

    public function getRating(): int
    {
        return $this->Rating;
    }

    public function setRating(int $Rating): void
    {
        $this->Rating = $Rating;
    }
}