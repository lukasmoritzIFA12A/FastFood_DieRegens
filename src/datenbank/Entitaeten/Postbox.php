<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\PostboxRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostboxRepository::class)]
#[ORM\Table(name: 'postbox')]
class Postbox
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private DateTime $nachrichtDatum;

    #[ORM\ManyToOne(targetEntity: Kunde::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Kunde_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Kunde $kunde;

    #[ORM\Column(type: 'string', length: 255)]
    private string $nachricht;

    #[ORM\Column(type: 'boolean')]
    private bool $gelesen;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }

    public function getNachrichtDatum(): string
    {
        return $this->nachrichtDatum->format("d.m.Y");
    }

    public function setNachrichtDatum(DateTime $nachrichtDatum): void
    {
        $this->nachrichtDatum = $nachrichtDatum;
    }

    public function getNachricht(): string
    {
        return $this->nachricht;
    }

    public function setNachricht(string $nachricht): void
    {
        $this->nachricht = $nachricht;
    }

    public function isGelesen(): bool
    {
        return $this->gelesen;
    }

    public function setGelesen(bool $gelesen): void
    {
        $this->gelesen = $gelesen;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'nachrichtDatum' => $this->getNachrichtDatum(),
            'kunde' => $this->getKunde()->jsonSerialize(),
            'nachricht' => $this->getNachricht(),
            'gelesen' => $this->isGelesen()
        ];
    }
}