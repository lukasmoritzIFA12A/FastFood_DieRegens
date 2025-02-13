<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Menue extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getTitel(): string
    {
        return $this->getBean()->getProperties()['Titel'];
    }

    public function setTitel(string $Titel): void
    {
        $this->getBean()->titel = $Titel;
    }

    public function getBeschreibung(): ?string
    {
        return $this->getBean()->getProperties()['Beschreibung'];
    }

    public function setBeschreibung(?string $Beschreibung): void
    {
        $this->getBean()->beschreibung = $Beschreibung;
    }
}