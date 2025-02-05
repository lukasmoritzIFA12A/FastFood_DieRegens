<?php

namespace Entitaeten;

class Login
{
    private int $idLogin;
    private string $Nutzername;
    private string $Passwort;

    public function __construct(int $idLogin, string $Nutzername, string $Passwort)
    {
        $this->idLogin = $idLogin;
        $this->Nutzername = $Nutzername;
        $this->Passwort = $Passwort;
    }

    public function getIdLogin(): int
    {
        return $this->idLogin;
    }

    public function setIdLogin(int $idLogin): void
    {
        $this->idLogin = $idLogin;
    }

    public function getNutzername(): string
    {
        return $this->Nutzername;
    }

    public function setNutzername(string $Nutzername): void
    {
        $this->Nutzername = $Nutzername;
    }

    public function getPasswort(): string
    {
        return $this->Passwort;
    }

    public function setPasswort(string $Passwort): void
    {
        $this->Passwort = $Passwort;
    }
}