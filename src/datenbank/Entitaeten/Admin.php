<?php

namespace datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'admin')]
class Admin
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $Login_id;

    public function getLoginId(): int
    {
        return $this->Login_id;
    }

    public function setLoginId(int $Login_id): void
    {
        $this->Login_id = $Login_id;
    }
}