<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Kunde extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    private function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getTelefonnummer(): ?string
    {
        return $this->getBean()->getProperties()['Telefonnummer'];
    }

    public function setTelefonnummer(?string $Telefonnummer): void
    {
        $this->getBean()->telefonnummer = $Telefonnummer;
    }

    public function getNachname(): string
    {
        return $this->getBean()->getProperties()['Nachname'];
    }

    public function setNachname(string $Nachname): void
    {
        $this->getBean()->nachname = $Nachname;
    }

    public function getVorname(): string
    {
        return $this->getBean()->getProperties()['Vorname'];
    }

    public function setVorname(string $Vorname): void
    {
        $this->getBean()->vorname = $Vorname;
    }

    public function getAdresseId(): int
    {
        return $this->getBean()->getProperties()['Adresse_id'];
    }

    public function setAdresseId(int $Adresse_id): void
    {
        $this->getBean()->adresse_id = $Adresse_id;
    }

    public function getRegistrierungsdatum(): string
    {
        return $this->getBean()->getProperties()['Registrierungsdatum'];
    }

    public function setRegistrierungsdatum(string $Registrierungsdatum): void
    {
        $this->getBean()->registrierungsdatum = $Registrierungsdatum;
    }

    public function getLoginId(): int
    {
        return $this->getBean()->getProperties()['Login_id'];
    }

    public function setLoginId(int $Login_id): void
    {
        $this->getBean()->login_id = $Login_id;
    }
}