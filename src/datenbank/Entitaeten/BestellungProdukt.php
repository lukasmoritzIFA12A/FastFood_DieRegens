<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\BestellungProduktRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BestellungProduktRepository::class)]
#[ORM\Table(name: 'bestellungprodukt')]
class BestellungProdukt
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bestellung::class, cascade: ["persist"], inversedBy: 'bestellungprodukte')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Bestellung $bestellung;

    #[ORM\ManyToOne(targetEntity: Produkt::class, cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Produkt $produkt;

    #[ORM\Column(type: 'integer')]
    private int $menge = 1;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProdukt(): Produkt
    {
        return $this->produkt;
    }

    public function setProdukt(Produkt $produkt): void
    {
        $this->produkt = $produkt;
    }

    public function getBestellung(): Bestellung
    {
        return $this->bestellung;
    }

    public function setBestellung(Bestellung $bestellung): void
    {
        $this->bestellung = $bestellung;
    }

    public function getMenge(): int
    {
        return $this->menge;
    }

    public function setMenge(int $menge): void
    {
        $this->menge = $menge;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'bestellung' => $this->getBestellung()->jsonSerialize(),
            'produkt' => $this->getProdukt()->jsonSerialize(),
            'menge' => $this->getMenge()
        ];
    }
}