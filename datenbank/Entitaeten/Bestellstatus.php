<?php

namespace Entitaeten;

class Bestellstatus
{
    private int $idBestellstatus;
    private string $status;

    public function __construct(int $idBestellstatus, string $status)
    {
        $this->idBestellstatus = $idBestellstatus;
        $this->status = $status;
    }

    public function getIdBestellstatus(): int
    {
        return $this->idBestellstatus;
    }

    public function setIdBestellstatus(int $idBestellstatus): void
    {
        $this->idBestellstatus = $idBestellstatus;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}