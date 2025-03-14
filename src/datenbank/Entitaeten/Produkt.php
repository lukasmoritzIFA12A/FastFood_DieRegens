<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\ProduktRepository;
use App\utils\Number;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduktRepository::class)]
#[ORM\Table(name: 'produkt')]
class Produkt
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bild::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bild_id", referencedColumnName: "id")]
    private Bild $bild;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Titel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $Beschreibung;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $Preis;

    #[ORM\Column(type: 'boolean')]
    private bool $ausverkauft;

    #[ORM\ManyToOne(targetEntity: Energiewert::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Energiewert_id", referencedColumnName: "id", nullable: true)]
    private ?Energiewert $energiewert;

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

    public function isAusverkauft(): bool
    {
        return $this->ausverkauft;
    }

    public function setAusverkauft(bool $ausverkauft): void
    {
        $this->ausverkauft = $ausverkauft;
    }

    public function getPreis(): string
    {
        return Number::reformatPreis($this->Preis);
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

    public function getEnergiewert(): ?Energiewert
    {
        return $this->energiewert;
    }

    public function setEnergiewert(?Energiewert $energiewert): void
    {
        $this->energiewert = $energiewert;
    }

    public function getBild(): Bild
    {
        return $this->bild;
    }

    public function setBild(Bild $bild): void
    {
        $this->bild = $bild;
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'bild' => $this->getBild()->jsonSerialize(),
            'Titel' => $this->getTitel(),
            'Beschreibung' => $this->getBeschreibung(),
            'Preis' => $this->getPreis(),
            'ausverkauft' => $this->isAusverkauft(),
            'energiewert' => $this->getEnergiewert()?->jsonSerialize(),
            'zutat' => $this->getZutat()->map(fn($c) => $c->jsonSerialize())->toArray()
        ];
    }
}