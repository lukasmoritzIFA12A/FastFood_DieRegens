<?php

namespace Entitaeten;

include_once dirname(__DIR__) . '/EntitaetsBean.php';

use EntitaetsBean;

class Admin extends EntitaetsBean
{
    public function getLoginId(): int
    {
        return $this->getBean()->getProperties()['Login_id'];
    }

    public function setLoginId(int $Login_id): void
    {
        $this->getBean()->login_id = $Login_id;
    }
}