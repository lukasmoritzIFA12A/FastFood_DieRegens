<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Icon extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getBildPfad(): string
    {
        return $this->getBean()->getProperties()['BildPfad'];
    }

    public function setBildPfad(string $BildPfad): void
    {
        $this->getBean()->bildpfad = $BildPfad;
    }
}