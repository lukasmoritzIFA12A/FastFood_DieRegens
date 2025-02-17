<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use datenbank\Repositories\LoginRepository;

include_once dirname(__DIR__) . '/Repositories/LoginRepository.php';

#[ORM\Entity(repositoryClass: LoginRepository::class)]
#[ORM\Table(name: 'login')]
class Login
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private string $Nutzername;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Passwort;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getNutzername(): string
    {
        return $this->Nutzername;
    }

    public function setNutzername(string $Nutzername): void
    {
        $this->Nutzername = $Nutzername;
    }

    public function getPasswort(): string
    {
        return $this->Passwort;
    }

    public function setPasswort(string $Passwort): void
    {
        $this->Passwort = $Passwort;
    }
}