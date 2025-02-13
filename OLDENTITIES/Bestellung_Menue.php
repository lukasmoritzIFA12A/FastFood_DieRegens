<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Bestellung_Menue extends EntitaetsBean
{
    public function getBestellungId(): int
    {
        return $this->getBean()->getProperties()['Bestellung_id'];
    }

    public function setBestellungId(int $Bestellung_id): void
    {
        $this->getBean()->bestellung_id = $Bestellung_id;
    }

    public function getMenueId(): int
    {
        return $this->getBean()->getProperties()['Menue_id'];
    }

    public function setMenueId(int $Menue_Id): void
    {
        $this->getBean()->menue_id = $Menue_Id;
    }
}