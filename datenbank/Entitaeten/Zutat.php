<?php

namespace Entitaeten;

class Zutat
{
    private int $idZutat;
    private string $ZutatName;

    public function __construct(int $idZutat, string $ZutatName)
    {
        $this->idZutat = $idZutat;
        $this->ZutatName = $ZutatName;
    }

    public function getIdZutat(): int
    {
        return $this->idZutat;
    }

    public function setIdZutat(int $idZutat): void
    {
        $this->idZutat = $idZutat;
    }

    public function getZutatName(): string
    {
        return $this->ZutatName;
    }

    public function setZutatName(string $ZutatName): void
    {
        $this->ZutatName = $ZutatName;
    }
}