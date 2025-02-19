<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\ZutatRepository;

#[ORM\Entity(repositoryClass: ZutatRepository::class)]
#[ORM\Table(name: 'zutat')]
class Zutat
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $ZutatName;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getZutatName(): string
    {
        return $this->ZutatName;
    }

    public function setZutatName(string $ZutatName): void
    {
        $this->ZutatName = $ZutatName;
    }
}