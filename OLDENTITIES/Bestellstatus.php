<?php

namespace OLDENTITIES;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use src\datenbank\EntitaetsBean;

class Bestellstatus extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getStatus(): string
    {
        return $this->getBean()->getProperties()['status'];
    }

    public function setStatus(string $status): void
    {
        $this->getBean()->status = $status;
    }
}