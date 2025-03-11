<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\datenbank\Entitaeten\Admin;
use App\datenbank\Entitaeten\Login;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\AdminRepository;
use App\datenbank\Repositories\LoginRepository;
use App\validation\PasswortHash;

try {
    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });

    if (isset($argv) || isset($argv[2])) {
        $entityManagerFactory = new EntityManagerFactory();
        $entityManger = $entityManagerFactory->createEntityManager();

        $login = new Login();
        $login->setNutzername($argv[1]);

        $hashedPassword = PasswortHash::hashPassword($argv[2]);
        $login->setPasswort($hashedPassword);

        $loginRepository = new LoginRepository($entityManger);
        $loginRepository->save($login);

        $admin = new Admin();
        $admin->setLogin($login);

        $adminRepository = new AdminRepository($entityManger);
        $adminRepository->save($admin);
    } else {
        echo "Bitte Nutzername und Passwort angeben! (Mit Leerzeichen getrennt)\n";
        exit();
    }
} catch (ErrorException $e) {
    echo "Fehler: " . $e->getMessage();
    exit();
} finally {
    restore_error_handler();
}

echo "Admin erfolgreich erstellt!\n";