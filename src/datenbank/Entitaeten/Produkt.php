<?php

namespace App\datenbank\Entitaeten;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\ProduktRepository;

#[ORM\Entity(repositoryClass: ProduktRepository::class)]
#[ORM\Table(name: 'produkt')]
class Produkt
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Icon::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Icon_id", referencedColumnName: "id")]
    private Icon $icon;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Titel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $Beschreibung;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $Preis;

    #[ORM\Column(type: "integer")]
    private int $Lagerbestand;

    #[ORM\ManyToMany(targetEntity: Zutat::class, cascade: ["persist"])]
    private Collection $zutat;

    public function __construct()
    {
        $this->zutat = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getLagerbestand(): int
    {
        return $this->Lagerbestand;
    }

    public function setLagerbestand(int $Lagerbestand): void
    {
        $this->Lagerbestand = $Lagerbestand;
    }

    public function getPreis(): string
    {
        return $this->Preis;
    }

    public function setPreis(string $Preis): void
    {
        $this->Preis = $Preis;
    }

    public function getBeschreibung(): ?string
    {
        return $this->Beschreibung;
    }

    public function setBeschreibung(?string $Beschreibung): void
    {
        $this->Beschreibung = $Beschreibung;
    }

    public function getIcon(): Icon
    {
        return $this->icon;
    }

    public function setIcon(Icon $icon): void
    {
        $this->icon = $icon;
    }

    public function getTitel(): string
    {
        return $this->Titel;
    }

    public function setTitel(string $Titel): void
    {
        $this->Titel = $Titel;
    }

    public function getZutat(): Collection
    {
        return $this->zutat;
    }

    public function setZutat(Collection $zutat): void
    {
        $this->zutat = $zutat;
    }
}