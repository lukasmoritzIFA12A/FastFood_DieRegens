<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'contest')]
class Contest
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'blob')]
    private string $bild;

    #[ORM\ManyToOne(targetEntity: Bestellung::class)]
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

    public function getBild(): string
    {
        return $this->bild;
    }

    public function setBild(string $bild): void
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
}