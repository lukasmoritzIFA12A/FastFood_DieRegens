<?php
namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'adresse')]
class Adresse
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Strassenname;

    #[ORM\Column(type: 'string', length: 10)]
    private string $Hausnummer;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $Zusatz;

    #[ORM\Column(type: 'string', length: 10)]
    private string $PLZ;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Stadt;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Bundesland;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStrassenname(): string
    {
        return $this->Strassenname;
    }

    public function setStrassenname(string $Strassenname): void
    {
        $this->Strassenname = $Strassenname;
    }

    public function getHausnummer(): string
    {
        return $this->Hausnummer;
    }

    public function setHausnummer(string $Hausnummer): void
    {
        $this->Hausnummer = $Hausnummer;
    }

    public function getZusatz(): string
    {
        return $this->Zusatz;
    }

    public function setZusatz(string $Zusatz): void
    {
        $this->Zusatz = $Zusatz;
    }

    public function getPLZ(): string
    {
        return $this->PLZ;
    }

    public function setPLZ(string $PLZ): void
    {
        $this->PLZ = $PLZ;
    }

    public function getStadt(): string
    {
        return $this->Stadt;
    }

    public function setStadt(string $Stadt): void
    {
        $this->Stadt = $Stadt;
    }

    public function getBundesland(): string
    {
        return $this->Bundesland;
    }

    public function setBundesland(string $Bundesland): void
    {
        $this->Bundesland = $Bundesland;
    }
}