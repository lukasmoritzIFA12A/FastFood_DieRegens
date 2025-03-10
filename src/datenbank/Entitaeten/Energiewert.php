<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\EnergiewertRepository;

#[ORM\Entity(repositoryClass: EnergiewertRepository::class)]
#[ORM\Table(name: 'energiewert')]
class Energiewert
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $PortionSize;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private ?string $Kalorien;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private ?string $Fett;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private ?string $Kohlenhydrate;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private ?string $Zucker;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private ?string $Eiweiss;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPortionSize(): ?string
    {
        return $this->PortionSize;
    }

    public function setPortionSize(?string $PortionSize): void
    {
        $this->PortionSize = $PortionSize;
    }

    public function getKalorien(): ?string
    {
        return $this->Kalorien;
    }

    public function setKalorien(?string $Kalorien): void
    {
        $this->Kalorien = $Kalorien;
    }

    public function getFett(): ?string
    {
        return $this->Fett;
    }

    public function setFett(?string $Fett): void
    {
        $this->Fett = $Fett;
    }

    public function getKohlenhydrate(): ?string
    {
        return $this->Kohlenhydrate;
    }

    public function setKohlenhydrate(?string $Kohlenhydrate): void
    {
        $this->Kohlenhydrate = $Kohlenhydrate;
    }

    public function getZucker(): ?string
    {
        return $this->Zucker;
    }

    public function setZucker(?string $Zucker): void
    {
        $this->Zucker = $Zucker;
    }

    public function getEiweiss(): ?string
    {
        return $this->Eiweiss;
    }

    public function setEiweiss(?string $Eiweiss): void
    {
        $this->Eiweiss = $Eiweiss;
    }
}