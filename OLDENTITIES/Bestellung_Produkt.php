<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Bestellung_Produkt extends EntitaetsBean
{
    public function getBestellungId(): int
    {
        return $this->getBean()->getProperties()['Bestellung_id'];
    }

    public function setBestellungId(int $Bestellung_id): void
    {
        $this->getBean()->bestellung_id = $Bestellung_id;
    }

    public function getProduktId(): int
    {
        return $this->getBean()->getProperties()['Produkt_id'];
    }

    public function setProduktId(int $Produkt_id): void
    {
        $this->getBean()->produkt_id = $Produkt_id;
    }
}