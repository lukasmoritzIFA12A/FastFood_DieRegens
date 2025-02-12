<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Zahlungsart extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getArt(): string
    {
        return $this->getBean()->getProperties()['Art'];
    }

    public function setArt(string $Art): void
    {
        $this->getBean()->art = $Art;
    }
}