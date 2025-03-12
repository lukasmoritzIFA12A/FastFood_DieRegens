<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\MenueRepository;
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

    #[ORM\ManyToOne(targetEntity: Bild::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bild_id", referencedColumnName: "id")]
    private Bild $bild;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Titel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $Beschreibung;

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

    public function getBild(): Bild
    {
        return $this->bild;
    }

    public function setBild(Bild $bild): void
    {
        $this->bild = $bild;
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

    public function getPreis(): string
    {
        $summe = "0.00";

        foreach ($this->produkte as $produkt) {
            $produktPreis = $produkt->getPreis();
            $produktPreis = str_replace('.', '', $produktPreis);
            $produktPreis = str_replace(',', '.', $produktPreis);

            $summe = bcadd($summe, $produktPreis, 2);
        }

        $summe = preg_replace('/[^0-9.]/', '', $summe);
        return number_format($summe, 2, ',', '.');
    }

    public function isAusverkauft(): bool
    {
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