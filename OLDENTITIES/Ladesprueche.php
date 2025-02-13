<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Ladesprueche extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getSpruch(): string
    {
        return $this->getBean()->getProperties()['spruch'];
    }

    public function setSpruch(string $spruch): void
    {
        $this->getBean()->spruch = $spruch;
    }
}