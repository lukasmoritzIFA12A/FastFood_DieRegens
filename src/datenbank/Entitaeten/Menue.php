<?php

namespace App\datenbank\Entitaeten;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\MenueRepository;

#[ORM\Entity(repositoryClass: MenueRepository::class)]
#[ORM\Table(name: 'menue')]
class Menue
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Titel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $Beschreibung;

    #[ORM\ManyToMany(targetEntity: Produkt::class, cascade: ["persist"])]
    private Collection $produkte;

    public function __construct()
    {
        $this->produkte = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBeschreibung(): ?string
    {
        return $this->Beschreibung;
    }

    public function setBeschreibung(?string $Beschreibung): void
    {
        $this->Beschreibung = $Beschreibung;
    }

    public function getTitel(): string
    {
        return $this->Titel;
    }

    public function setTitel(string $Titel): void
    {
        $this->Titel = $Titel;
    }

    public function getProdukte(): Collection
    {
        return $this->produkte;
    }

    public function setProdukte(Collection $produkte): void
    {
        $this->produkte = $produkte;
    }
}