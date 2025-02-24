<?php
namespace Src\Utils;

class Router {
    private static $basePath = "/FastFood_DieRegens/src"; // Passe den Basis-Pfad an falls nötig

    public static function url($path) {
        return self::$basePath . $path;
    }
}

// Beispiel-Aufruf:
// echo Router::url('/view/kontaktformular.php');
