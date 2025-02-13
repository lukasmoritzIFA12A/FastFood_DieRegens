<?php
namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Adresse extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getBundesland(): string
    {
        return $this->getBean()->getProperties()['Bundesland'];
    }

    public function setBundesland(string $Bundesland): void
    {
        $this->getBean()->bundesland = $Bundesland;
    }

    public function getStadt(): string
    {
        return $this->getBean()->getProperties()['Stadt'];
    }

    public function setStadt(string $Stadt): void
    {
        $this->getBean()->stadt = $Stadt;
    }

    public function getZusatz(): ?string
    {
        return $this->getBean()->getProperties()['Zusatz'];
    }

    public function setZusatz(?string $Zusatz): void
    {
        $this->getBean()->zusatz = $Zusatz;
    }

    public function getPLZ(): string
    {
        return $this->getBean()->getProperties()['PLZ'];
    }

    public function setPLZ(string $PLZ): void
    {
        $this->getBean()->plz = $PLZ;
    }

    public function getHausnummer(): string
    {
        return $this->getBean()->getProperties()['Hausnummer'];
    }

    public function setHausnummer(string $Hausnummer): void
    {
        $this->getBean()->hausnummer = $Hausnummer;
    }

    public function getStrassenname(): string
    {
        return $this->getBean()->getProperties()['Strassenname'];
    }

    public function setStrassenname(string $Strassenname): void
    {
        $this->getBean()->strassenname = $Strassenname;
    }
}