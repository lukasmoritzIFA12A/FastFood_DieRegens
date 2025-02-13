<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
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