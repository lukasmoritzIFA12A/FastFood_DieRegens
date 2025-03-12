<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\RechnungRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RechnungRepository::class)]
#[ORM\Table(name: 'rechnung')]
class Rechnung
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bestellung::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bestellung_id", referencedColumnName: "id")]
    private Bestellung $bestellung;

    #[ORM\Column(type: 'datetime')]
    private DateTime $ZahlungsDatum;

    #[ORM\ManyToOne(targetEntity: Rabatt::class, cascade: ["persist"])]
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

    public function getRabatt(): ?Rabatt
    {
        return $this->rabatt;
    }

    public function setRabatt(?Rabatt $rabatt): void
    {
        $this->rabatt = $rabatt;
    }

    public function getZahlungsDatum(): string
    {
        return $this->ZahlungsDatum->format("d.m.Y - H:i");
    }

    public function setZahlungsDatum(DateTime $ZahlungsDatum): void
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

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'bestellung' => $this->getBestellung()->jsonSerialize(),
            'ZahlungsDatum' => $this->getZahlungsDatum(),
            'rabatt' => $this->getRabatt()->jsonSerialize()
        ];
    }
}