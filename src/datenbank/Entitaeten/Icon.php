<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\IconRepository;

#[ORM\Entity(repositoryClass: IconRepository::class)]
#[ORM\Table(name: 'icon')]
class Icon
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $BildPfad;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBildPfad(): string
    {
        return $this->BildPfad;
    }

    public function setBildPfad(string $BildPfad): void
    {
        $this->BildPfad = $BildPfad;
    }
}