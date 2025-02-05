<?php

namespace Entitaeten;

class Admin
{
    private int $Login_idLogin;

    public function __construct(int $Login_idLogin)
    {
        $this->Login_idLogin = $Login_idLogin;
    }

    public function getLoginIdLogin(): int
    {
        return $this->Login_idLogin;
    }

    public function setLoginIdLogin(int $Login_idLogin): void
    {
        $this->Login_idLogin = $Login_idLogin;
    }
}