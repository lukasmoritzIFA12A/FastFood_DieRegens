<?php

use RedBeanPHP\OODBBean;

class EntitaetsBean
{
    protected OODBBean $bean;

    public function __construct(OODBBean $bean)
    {
        $this->bean = $bean;
    }

    public function getBean(): OODBBean
    {
        return $this->bean;
    }
}