<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\BildRepository;

#[ORM\Entity(repositoryClass: BildRepository::class)]
#[ORM\Table(name: 'bild')]
class Bild
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'blob')]
    private string $bild;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBild(): string
    {
        return $this->bild;
    }

    public function setBild(string $bild): void
    {
        $this->bild = $bild;
    }
}