<?php

namespace App\components\kundenverwaltung\login;

use App\datenbank\Entitaeten\Login;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\AdminRepository;
use App\datenbank\Repositories\LoginRepository;
use App\validation\PasswortHash;

class LoginLogic
{
    public string $errorMessage = "";

    public function einloggen(?string $username, ?string $password): int|bool
    {
        if (!$username || !$password) {
            $this->errorMessage = "Unerwarteter Fehler: Nutzername und/oder Passwort fehlt!";
            return false;
        }

        $entityManager = EntityManagerFactory::createEntityManager();
        $loginRepository = new LoginRepository($entityManager);
        $userGefunden = $loginRepository->findByUsername($username);
        if ($userGefunden) {
            $correct = PasswortHash::verifyPassword($password, $userGefunden->getPasswort());
            if ($correct) {
                $this->errorMessage = "";
                return $userGefunden->getId();
            }
        }

        $this->errorMessage = "Ungültiger Benutzername oder Passwort!";
        return false;
    }

    public function istAdmin(int $loginId): bool
    {
        $entityManager = EntityManagerFactory::createEntityManager();
        $adminRepository = new AdminRepository($entityManager);
        $admin = $adminRepository->find($loginId);
        if ($admin) {
            $this->errorMessage = "";
            return true;
        }
        return false;
    }
}