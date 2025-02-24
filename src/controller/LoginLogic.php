<?php

namespace App\controller;

use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\LoginRepository;
use App\validation\PasswortHash;

class LoginLogic
{
    public string $errorMessage = "";

    public function einloggen(?string $username, ?string $password): bool
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
                return true;
            }
        }

        $this->errorMessage = "Ungültiger Benutzername oder Passwort!";
        return false;
    }
}