<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Energiewert extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getPortionSize(): ?string
    {
        return $this->getBean()->getProperties()['PortionSize'];
    }

    public function setPortionSize(?string $PortionSize): void
    {
        $this->getBean()->portionsize = $PortionSize;
    }

    public function getProduktId(): int
    {
        return $this->getBean()->getProperties()['Produkt_id'];
    }

    public function setProduktId(int $Produkt_id): void
    {
        $this->getBean()->produkt_id = $Produkt_id;
    }

    public function getKalorien(): ?string
    {
        return $this->getBean()->getProperties()['Kalorien'];
    }

    public function setKalorien(?string $Kalorien): void
    {
        $this->getBean()->kalorien = $Kalorien;
    }

    public function getFett(): ?string
    {
        return $this->getBean()->getProperties()['Fett'];
    }

    public function setFett(?string $Fett): void
    {
        $this->getBean()->fett = $Fett;
    }

    public function getKohlenhydrate(): ?string
    {
        return $this->getBean()->getProperties()['Kohlenhydrate'];
    }

    public function setKohlenhydrate(?string $Kohlenhydrate): void
    {
        $this->getBean()->kohlenhydrate = $Kohlenhydrate;
    }

    public function getZucker(): ?string
    {
        return $this->getBean()->getProperties()['Zucker'];
    }

    public function setZucker(?string $Zucker): void
    {
        $this->getBean()->zucker = $Zucker;
    }

    public function getEiweiss(): ?string
    {
        return $this->getBean()->getProperties()['Eiweiss'];
    }

    public function setEiweiss(?string $Eiweiss): void
    {
        $this->getBean()->eiweiss = $Eiweiss;
    }
}