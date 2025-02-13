<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'admin')]
class Admin
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Login::class)]
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