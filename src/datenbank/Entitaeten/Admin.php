<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: 'admin')]
class Admin
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Login::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Login_id", referencedColumnName: "id")]
    private Login $login;

    public function getLogin(): Login
    {
        return $this->login;
    }

    public function setLogin(Login $login): void
    {
        $this->login = $login;
    }
}