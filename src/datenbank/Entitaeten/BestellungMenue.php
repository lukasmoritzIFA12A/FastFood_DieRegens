<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\BestellungMenueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BestellungMenueRepository::class)]
#[ORM\Table(name: 'bestellungmenue')]
class BestellungMenue
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bestellung::class, cascade: ["persist"], inversedBy: 'bestellungmenues')]
    #[ORM\JoinColumn(nullable: false)]
    private Bestellung $bestellung;

    #[ORM\ManyToOne(targetEntity: Menue::class, cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private Menue $menue;

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

    public function getMenge(): int
    {
        return $this->menge;
    }

    public function setMenge(int $menge): void
    {
        $this->menge = $menge;
    }

    public function getMenue(): Menue
    {
        return $this->menue;
    }

    public function setMenue(Menue $menue): void
    {
        $this->menue = $menue;
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
            'menue' => $this->getMenue()->jsonSerialize(),
            'menge' => $this->getMenge()
        ];
    }
}