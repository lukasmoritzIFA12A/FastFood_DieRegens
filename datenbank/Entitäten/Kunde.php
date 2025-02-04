<?php

namespace Entitäten;

use DateTime;

class Kunde
{
    private int $idKunde;
    private int $Adresse_idAdresse;
    private string $Vorname;
    private string $Nachname;
    private ?string $Telefonnummer;
    private DateTime $Registrierungsdatum;
    private int $Login_idLogin;
    private int $Kundenstatus_idKundenstatus;

    public function __construct(int $idKunde, int $Adresse_idAdresse, string $Vorname, ?string $Telefonnummer, string $Nachname, DateTime $Registrierungsdatum, int $Login_idLogin, int $Kundenstatus_idKundenstatus)
    {
        $this->idKunde = $idKunde;
        $this->Adresse_idAdresse = $Adresse_idAdresse;
        $this->Vorname = $Vorname;
        $this->Telefonnummer = $Telefonnummer;
        $this->Nachname = $Nachname;
        $this->Registrierungsdatum = $Registrierungsdatum;
        $this->Login_idLogin = $Login_idLogin;
        $this->Kundenstatus_idKundenstatus = $Kundenstatus_idKundenstatus;
    }

    public function getIdKunde(): int
    {
        return $this->idKunde;
    }

    public function setIdKunde(int $idKunde): void
    {
        $this->idKunde = $idKunde;
    }

    public function getKundenstatusIdKundenstatus(): int
    {
        return $this->Kundenstatus_idKundenstatus;
    }

    public function setKundenstatusIdKundenstatus(int $Kundenstatus_idKundenstatus): void
    {
        $this->Kundenstatus_idKundenstatus = $Kundenstatus_idKundenstatus;
    }

    public function getTelefonnummer(): ?string
    {
        return $this->Telefonnummer;
    }

    public function setTelefonnummer(?string $Telefonnummer): void
    {
        $this->Telefonnummer = $Telefonnummer;
    }

    public function getNachname(): string
    {
        return $this->Nachname;
    }

    public function setNachname(string $Nachname): void
    {
        $this->Nachname = $Nachname;
    }

    public function getVorname(): string
    {
        return $this->Vorname;
    }

    public function setVorname(string $Vorname): void
    {
        $this->Vorname = $Vorname;
    }

    public function getAdresseIdAdresse(): int
    {
        return $this->Adresse_idAdresse;
    }

    public function setAdresseIdAdresse(int $Adresse_idAdresse): void
    {
        $this->Adresse_idAdresse = $Adresse_idAdresse;
    }

    public function getRegistrierungsdatum(): DateTime
    {
        return $this->Registrierungsdatum;
    }

    public function setRegistrierungsdatum(DateTime $Registrierungsdatum): void
    {
        $this->Registrierungsdatum = $Registrierungsdatum;
    }

    public function getLoginIdLogin(): int
    {
        return $this->Login_idLogin;
    }

    public function setLoginIdLogin(int $Login_idLogin): void
    {
        $this->Login_idLogin = $Login_idLogin;
    }
}