<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use datenbank\Repositories\RechnungRepository;

#[ORM\Entity(repositoryClass: RechnungRepository::class)]
#[ORM\Table(name: 'rechnung')]
class Rechnung
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bestellung::class)]
    #[ORM\JoinColumn(name: "Bestellung_id", referencedColumnName: "id")]
    private Bestellung $bestellung;

    #[ORM\Column(type: 'datetime')]
    private string $ZahlungsDatum;

    #[ORM\ManyToOne(targetEntity: Rabatt::class)]
    #[ORM\JoinColumn(name: "Rabatt_id", referencedColumnName: "id", nullable: true)]
    private Rabatt $rabatt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRabatt(): Rabatt
    {
        return $this->rabatt;
    }

    public function setRabatt(Rabatt $rabatt): void
    {
        $this->rabatt = $rabatt;
    }

    public function getZahlungsDatum(): string
    {
        return $this->ZahlungsDatum;
    }

    public function setZahlungsDatum(string $ZahlungsDatum): void
    {
        $this->ZahlungsDatum = $ZahlungsDatum;
    }

    public function getBestellung(): Bestellung
    {
        return $this->bestellung;
    }

    public function setBestellung(Bestellung $bestellung): void
    {
        $this->bestellung = $bestellung;
    }
}