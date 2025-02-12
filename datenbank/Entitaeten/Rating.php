<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Rating extends EntitaetsBean
{
    public function getId(): int
    {
        return $this->getBean()->getProperties()['id'];
    }

    public function setId(int $id): void
    {
        $this->getBean()->id = $id;
    }

    public function getKundeId(): int
    {
        return $this->getBean()->getProperties()['Kunde_id'];
    }

    public function setKundeId(int $Kunde_id): void
    {
        $this->getBean()->kunde_id = $Kunde_id;
    }

    public function getContestId(): int
    {
        return $this->getBean()->getProperties()['Contest_id'];
    }

    public function setContestId(int $Contest_id): void
    {
        $this->getBean()->contest_id = $Contest_id;
    }

    public function getRating(): int
    {
        return $this->getBean()->getProperties()['Rating'];
    }

    public function setRating(int $Rating): void
    {
        $this->getBean()->rating = $Rating;
    }
}