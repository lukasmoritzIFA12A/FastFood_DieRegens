<?php

namespace Entitäten;

class Rabatt
{
    private int $idRabatt;
    private string $code;
    private string $minderung; //kein float wegen rundungsfehlern!

    public function __construct(int $idRabatt, string $code, string $minderung)
    {
        $this->idRabatt = $idRabatt;
        $this->code = $code;
        $this->minderung = $minderung;
    }

    public function getIdRabatt(): int
    {
        return $this->idRabatt;
    }

    public function setIdRabatt(int $idRabatt): void
    {
        $this->idRabatt = $idRabatt;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getMinderung(): string
    {
        return $this->minderung;
    }

    public function setMinderung(string $minderung): void
    {
        $this->minderung = $minderung;
    }
}