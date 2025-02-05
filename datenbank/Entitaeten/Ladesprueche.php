<?php

namespace Entitaeten;

class Ladesprueche
{
    private int $idLadesprueche;
    private string $spruch;

    public function __construct(int $idLadesprueche, string $spruch)
    {
        $this->idLadesprueche = $idLadesprueche;
        $this->spruch = $spruch;
    }

    public function getIdLadesprueche(): int
    {
        return $this->idLadesprueche;
    }

    public function setIdLadesprueche(int $idLadesprueche): void
    {
        $this->idLadesprueche = $idLadesprueche;
    }

    public function getSpruch(): string
    {
        return $this->spruch;
    }

    public function setSpruch(string $spruch): void
    {
        $this->spruch = $spruch;
    }
}