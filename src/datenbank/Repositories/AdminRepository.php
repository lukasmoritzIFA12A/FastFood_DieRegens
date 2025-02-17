<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Admin.php';

use datenbank\Entitaeten\Admin;
use datenbank\Entitaeten\Login;
use Doctrine\ORM\EntityRepository;

class AdminRepository extends EntityRepository
{
    public function exists(Login $login): bool
    {
        $admin = $this->findOneBy(['login' => $login]);
        return $admin !== null;
    }

    public function create(Login $login): Admin
    {
        $loginRepository = $this->getEntityManager()->getRepository(Login::class);
        $login = $loginRepository->find($login->getId());

        if (!$login) {
            throw new \Exception("Login nicht gefunden");
        }

        $admin = new Admin();
        $admin->setLogin($login);
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
        return $admin;
    }
}