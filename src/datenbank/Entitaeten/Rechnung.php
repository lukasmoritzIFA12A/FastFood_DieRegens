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
    #[ORM\JoinColumn(name: "Bestellung_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Bestellung $bestellung;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $ZahlungsDatum;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getZahlungsDatum(): ?string
    {
        return $this->ZahlungsDatum?->format("d.m.Y - H:i");
    }

    public function setZahlungsDatum(?DateTime $ZahlungsDatum): void
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
            'ZahlungsDatum' => $this->getZahlungsDatum()
        ];
    }
}