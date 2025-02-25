<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\validation\PasswortHash;

if (isset($argv)) {
    $hash = PasswortHash::hashPassword($argv[1]);
    echo "Passwort erfolgreich gehashed: $hash";
} else {
    echo "Kein Passwort wurde übergeben.";
    exit();
}