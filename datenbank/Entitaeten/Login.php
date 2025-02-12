<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Login extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getNutzername(): string
    {
        return $this->getBean()->getProperties()['Nutzername'];
    }

    public function setNutzername(string $Nutzername): void
    {
        $this->getBean()->nutzername = $Nutzername;
    }

    public function getPasswort(): string
    {
        return $this->getBean()->getProperties()['Passwort'];
    }

    public function setPasswort(string $Passwort): void
    {
        $this->getBean()->passwort = $Passwort;
    }
}