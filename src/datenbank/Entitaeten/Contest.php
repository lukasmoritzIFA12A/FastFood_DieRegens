<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\ContestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContestRepository::class)]
#[ORM\Table(name: 'contest')]
class Contest
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Bild::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bild_id", referencedColumnName: "id")]
    private Bild $bild;

    #[ORM\ManyToOne(targetEntity: Bestellung::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bestellung_id", referencedColumnName: "id")]
    private Bestellung $bestellung;

    #[ORM\Column(type: 'boolean')]
    private bool $freigeschalten;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBestellung(): Bestellung
    {
        return $this->bestellung;
    }

    public function setBestellung(Bestellung $bestellung): void
    {
        $this->bestellung = $bestellung;
    }

    public function getBild(): Bild
    {
        return $this->bild;
    }

    public function setBild(Bild $bild): void
    {
        $this->bild = $bild;
    }

    public function isFreigeschalten(): bool
    {
        return $this->freigeschalten;
    }

    public function setFreigeschalten(bool $freigeschalten): void
    {
        $this->freigeschalten = $freigeschalten;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'bild' => $this->getBild()->jsonSerialize(),
            'bestellung' => $this->getBestellung()->jsonSerialize(),
            'freigeschalten' => $this->isFreigeschalten()
        ];
    }
}