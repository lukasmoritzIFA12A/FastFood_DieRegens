<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\MenueRepository;
use App\utils\Number;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenueRepository::class)]
#[ORM\Table(name: 'menue')]
class Menue
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bild::class, cascade: ["remove", "persist"])]
    #[ORM\JoinColumn(name: "Bild_id", referencedColumnName: "id")]
    private Bild $bild;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Titel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $Beschreibung;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $Preis;

    #[ORM\ManyToMany(targetEntity: Produkt::class, cascade: ["persist"], orphanRemoval: true)]
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

    public function getBild(): Bild
    {
        return $this->bild;
    }

    public function setBild(Bild $bild): void
    {
        $this->bild = $bild;
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

    public function getTitel(int $maxLength = 40): string
    {
        if (!$this->Titel) {
            return "";
        }

        return (mb_strlen($this->Titel) > $maxLength)
            ? mb_substr($this->Titel, 0, $maxLength) . "..."
            : $this->Titel;
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

    public function isAusverkauft(): bool
    {
        if ($this->produkte->isEmpty()) {
            return true;
        }

        foreach ($this->produkte as $produkt) {
            if ($produkt->isAusverkauft()) {
                return true;
            }
        }
        return false;
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
            'produkte' => $this->getProdukte()->map(fn($c) => $c->jsonSerialize())->toArray()
        ];
    }
}