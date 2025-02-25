<?php
namespace App\utils;

class router {
    private static string $basePath = "/FastFood/src"; // Passe den Basis-Pfad an falls nötig

    public static function url($path): string
    {
        return self::$basePath . $path;
    }
}

// Beispiel-Aufruf:
// echo Router::url('/view/kontaktformular.php');
