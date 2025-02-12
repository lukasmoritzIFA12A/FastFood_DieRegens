<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Rabatt extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getCode(): string
    {
        return $this->getBean()->getProperties()['code'];
    }

    public function setCode(string $code): void
    {
        $this->getBean()->code = $code;
    }

    public function getMinderung(): string
    {
        return $this->getBean()->getProperties()['minderung'];
    }

    public function setMinderung(string $minderung): void
    {
        $this->getBean()->minderung = $minderung;
    }
}