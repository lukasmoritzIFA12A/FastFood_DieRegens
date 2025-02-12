<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Zutat extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getZutatName(): string
    {
        return $this->getBean()->getProperties()['ZutatName'];
    }

    public function setZutatName(string $ZutatName): void
    {
        $this->getBean()->zutatname = $ZutatName;
    }
}