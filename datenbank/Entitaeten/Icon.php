<?php

namespace Entitaeten;

class Icon
{
    private int $idIcon;
    private string $BildPfad;

    public function __construct(string $BildPfad, int $idIcon)
    {
        $this->BildPfad = $BildPfad;
        $this->idIcon = $idIcon;
    }

    public function getIdIcon(): int
    {
        return $this->idIcon;
    }

    public function setIdIcon(int $idIcon): void
    {
        $this->idIcon = $idIcon;
    }

    public function getBildPfad(): string
    {
        return $this->BildPfad;
    }

    public function setBildPfad(string $BildPfad): void
    {
        $this->BildPfad = $BildPfad;
    }
}