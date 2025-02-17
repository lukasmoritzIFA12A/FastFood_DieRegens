<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Login.php';

use datenbank\Entitaeten\Login;
use Doctrine\ORM\EntityRepository;
use Exception;

class LoginRepository extends EntityRepository
{
    public function exists(int $id): bool
    {
        $login = $this->findOneBy(['id' => $id]);
        return $login !== null;
    }

    /**
     * @throws Exception
     */
    public function create(string $Nutzername, string $Passwort): Login
    {
        $login = new Login();
        $login->setNutzername($Nutzername);
        $login->setPasswort($Passwort);
        $this->getEntityManager()->persist($login);
        $this->getEntityManager()->flush();
        return $login;
    }
}