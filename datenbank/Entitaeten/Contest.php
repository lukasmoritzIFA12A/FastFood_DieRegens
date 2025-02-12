<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Contest extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getBestellungId(): int
    {
        return $this->getBean()->getProperties()['Bestellung_id'];
    }

    public function setBestellungId(int $Bestellung_id): void
    {
        $this->getBean()->bestellung_id = $Bestellung_id;
    }

    public function getBild(): string
    {
        return $this->getBean()->getProperties()['Bild'];
    }

    public function setBild(string $bild): void
    {
        $this->getBean()->bild = $bild;
    }

    public function isFreigeschalten(): bool
    {
        return $this->getBean()->getProperties()['Freigeschalten'];
    }

    public function setFreigeschalten(bool $freigeschalten): void
    {
        $this->getBean()->freigeschalten = $freigeschalten;
    }
}