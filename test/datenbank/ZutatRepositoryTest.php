<?php

namespace Test\Datenbank;

require_once dirname(__DIR__, 2) . "/src/datenbank/bootstrap.php";

use datenbank\Entitaeten\Admin;
use datenbank\Entitaeten\Login;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class ZutatRepositoryTest extends TestCase
{
    public function testAdmin(): void
    {
        require_once dirname(__DIR__, 2) . "/src/datenbank/bootstrap.php";

        $loginRepository =  $this->entityManager->getRepository(Login::class);
        $login = $loginRepository->create("Nutzer", "Passwort");

        $adminRepository =  $this->entityManager->getRepository(Admin::class);
        $exists = $adminRepository->create($login);
    }
}