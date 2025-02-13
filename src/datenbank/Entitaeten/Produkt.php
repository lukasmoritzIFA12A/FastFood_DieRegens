<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'produkt')]
class Produkt
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Icon::class)]
    #[ORM\JoinColumn(name: "Icon_id", referencedColumnName: "id")]
    private Icon $icon;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Titel;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $Beschreibung;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $Preis;

    #[ORM\Column(type: "integer")]
    private int $Lagerbestand;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private string $Rabatt;

    #[ORM\ManyToMany(targetEntity: Zutat::class)]
    private Zutat $zutat;

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

    public function getBeschreibung(): string
    {
        return $this->Beschreibung;
    }

    public function setBeschreibung(string $Beschreibung): void
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

    public function getRabatt(): string
    {
        return $this->Rabatt;
    }

    public function setRabatt(string $Rabatt): void
    {
        $this->Rabatt = $Rabatt;
    }

    public function getZutat(): Zutat
    {
        return $this->zutat;
    }

    public function setZutat(Zutat $zutat): void
    {
        $this->zutat = $zutat;
    }
}