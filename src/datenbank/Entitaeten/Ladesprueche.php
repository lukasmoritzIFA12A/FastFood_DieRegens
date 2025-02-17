<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use datenbank\Repositories\LadespruecheRepository;

#[ORM\Entity(repositoryClass: LadespruecheRepository::class)]
#[ORM\Table(name: 'ladesprueche')]
class Ladesprueche
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $spruch;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSpruch(): string
    {
        return $this->spruch;
    }

    public function setSpruch(string $spruch): void
    {
        $this->spruch = $spruch;
    }
}