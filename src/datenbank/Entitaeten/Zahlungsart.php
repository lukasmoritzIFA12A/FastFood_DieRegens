<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\ZahlungsartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZahlungsartRepository::class)]
#[ORM\Table(name: 'zahlungsart')]
class Zahlungsart
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Art;

    #[ORM\ManyToOne(targetEntity: Bild::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bild_id", referencedColumnName: "id")]
    private Bild $bild;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getArt(): string
    {
        return $this->Art;
    }

    public function setArt(string $Art): void
    {
        $this->Art = $Art;
    }

    public function getBild(): Bild
    {
        return $this->bild;
    }

    public function setBild(Bild $bild): void
    {
        $this->bild = $bild;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'Art' => $this->getArt(),
            'bild' => $this->getBild()->jsonSerialize()
        ];
    }
}