<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use datenbank\Repositories\RabattRepository;

#[ORM\Entity(repositoryClass: RabattRepository::class)]
#[ORM\Table(name: 'rabatt')]
class Rabatt
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    private string $code;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private string $minderung;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMinderung(): string
    {
        return $this->minderung;
    }

    public function setMinderung(string $minderung): void
    {
        $this->minderung = $minderung;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}