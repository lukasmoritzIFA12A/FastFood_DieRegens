<?php

    use Repositories\AdresseRepository;

    require 'datenbank/DatenbankAccess.php';
    require 'datenbank/Repositories/AdresseRepository.php';

    $datenbank = new DatenbankAccess();

    $adresse = new AdresseRepository($datenbank->getConnection());
    $result = $adresse->getById(1);

    if ($result == null) {
        echo ('Result ist null'.'<br>');
    } else {
        echo "<br>"."idAdresse: " . $result->getIdAdresse()."<br>";
        echo "Strassenname: " . $result->getStrassenname()."<br>";
        echo "Hausnummer: " . $result->getHausnummer()."<br>";
        echo "Zusatz: " . $result->getZusatz()."<br>";
        echo "PLZ: " . $result->getPLZ()."<br>";
        echo "Stadt: " . $result->getStadt()."<br>";
        echo "Bundesland: " . $result->getBundesland()."<br>";
    }

    $resultArray = $adresse->getAll();

    if (empty($resultArray)) {
        echo ('Result ist empty'.'<br>');
    } else {
        foreach ($resultArray as $res) {
            echo "<br>"."idAdresse: " . $res->getIdAdresse()."<br>";
            echo "Strassenname: " . $res->getStrassenname()."<br>";
            echo "Hausnummer: " . $res->getHausnummer()."<br>";
            echo "Zusatz: " . $res->getZusatz()."<br>";
            echo "PLZ: " . $res->getPLZ()."<br>";
            echo "Stadt: " . $res->getStadt()."<br>";
            echo "Bundesland: " . $res->getBundesland()."<br>";
        }
    }