<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Produkt_Zutat extends EntitaetsBean
{
    public function getProduktId(): int
    {
        return $this->getBean()->getProperties()['Produkt_id'];
    }

    public function setProduktId(int $Produkt_id): void
    {
        $this->getBean()->produkt_id = $Produkt_id;
    }

    public function getZutatId(): int
    {
        return $this->getBean()->getProperties()['Zutat_id'];
    }

    public function setZutatId(int $Zutat_id): void
    {
        $this->getBean()->zutat_id = $Zutat_id;
    }
}