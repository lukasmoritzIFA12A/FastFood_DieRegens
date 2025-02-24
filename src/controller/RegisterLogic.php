<?php

namespace App\controller;

use App\datenbank\Entitaeten\Adresse;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Login;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\KundeRepository;
use App\datenbank\Repositories\LoginRepository;
use App\util\BundeslandFetcher;
use App\validation\PasswortHash;
use DateMalformedStringException;
use DateTime;
use DateTimeZone;

class RegisterLogic
{
    public string $errorMessage = "";

    public function registrieren(Kunde $kunde): bool
    {
        $entityManager = EntityManagerFactory::createEntityManager();
        $kundeRepository = new KundeRepository($entityManager);

        if ($kundeRepository->save($kunde)) {
            return true;
        } else {
            $this->errorMessage = "Unerwarteter Fehler: Registrierung fehlgeschlagen!";
            return false;
        }
    }

    public function createLogin(?string $username, ?string $password, ?string $passwordWiederholen): bool|Login
    {
        if (!$username || !$password || !$passwordWiederholen) {
            $this->errorMessage = "Unerwarteter Fehler: Nutzername und Passwort fehlen!";
            return false;
        }

        if ($password !== $passwordWiederholen) {
            $this->errorMessage = "Passwort Wiederholung stimmt nicht mit Passwort überein!";
            return false;
        }

        $entityManager = EntityManagerFactory::createEntityManager();
        $loginRepository = new LoginRepository($entityManager);
        $userGefunden = $loginRepository->findByUsername($username);
        if ($userGefunden) {
            $this->errorMessage = "Nutzername bereits vergeben!";
            return false;
        }

        $login = new Login();
        $login->setNutzername($username);
        $login->setPasswort(PasswortHash::hashPassword($password));
        return $login;
    }

    public function createKunde(Login $login, Adresse $adresse, ?string $vorname, ?string $nachname, ?string $telefonnummer): bool|Kunde
    {
        $kunde = new Kunde();
        try {
            $kunde->setRegistrierungsdatum(new DateTime('now', new DateTimeZone('Europe/Berlin')));
        } catch (DateMalformedStringException $e) {
            $this->errorMessage = "Unerwarteter Fehler: ".$e->getMessage();
            return false;
        }
        $kunde->setLogin($login);
        $kunde->setAdresse($adresse);

        if ($vorname && $nachname) {
            $kunde->setVorname($vorname);
            $kunde->setNachname($nachname);
        } else {
            $this->errorMessage = "Unerwarteter Fehler: Vor- und Nachname fehlt!";
            return false;
        }

        if ($telefonnummer) {
            $kunde->setTelefonnummer($telefonnummer);
        }

        return $kunde;
    }

    public function createAdresse(?string $strasse, ?string $hausnummer, ?string $stadt, ?string $plz, ?string $zusatz): bool|Adresse
    {
        $adresse = new Adresse();
        if ($strasse && $hausnummer && $stadt && $plz) {
            $adresse->setStrassenname($strasse);
            $adresse->setHausnummer($hausnummer);
            $adresse->setStadt($stadt);
            $adresse->setPLZ($plz);

            $bundesland = BundeslandFetcher::getBundesland($plz);
            if (!$bundesland) {
                $this->errorMessage = "Invalide PLZ!";
                return false;
            }

            $adresse->setBundesland($bundesland);
        } else {
            $this->errorMessage = "Unerwarteter Fehler: Adresse fehlt!";
            return false;
        }

        if ($zusatz) {
            $adresse->setZusatz($zusatz);
        }

        return $adresse;
    }
}