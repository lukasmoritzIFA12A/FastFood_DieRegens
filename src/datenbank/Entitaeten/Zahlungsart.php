<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use datenbank\Repositories\ZahlungsartRepository;

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
}