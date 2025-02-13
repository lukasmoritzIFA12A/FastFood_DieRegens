<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Menue_Produkt extends EntitaetsBean
{
    public function getMenueId(): int
    {
        return $this->getBean()->getProperties()['Menue_id'];
    }

    public function setMenueId(int $Menue_id): void
    {
        $this->getBean()->menue_id = $Menue_id;
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