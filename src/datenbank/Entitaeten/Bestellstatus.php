<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\BestellstatusRepository;

#[ORM\Entity(repositoryClass: BestellstatusRepository::class)]
#[ORM\Table(name: 'bestellstatus')]
class Bestellstatus
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $status;

    #[ORM\Column(type: 'string', length: 7)]
    private string $farbe;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getFarbe(): string
    {
        return $this->farbe;
    }

    public function setFarbe(string $farbe): void
    {
        $this->farbe = $farbe;
    }
}