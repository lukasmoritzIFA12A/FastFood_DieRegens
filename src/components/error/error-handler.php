<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function customErrorHandler($errno, $errstr, $errfile, $errline): void
{
    while (ob_get_level()) {
        ob_end_clean(); // Löscht ALLES, was vorher ausgegeben wurde
    }

    header("Content-Type: text/html; charset=UTF-8");
    http_response_code(500); // Setzt den Statuscode auf "Internal Server Error"

    error_log($errstr);

    $details = $errno.":\n"."Fehler in $errfile auf Zeile $errline: $errstr";
    include 'error-fenster.php';
    die;
}

#[NoReturn] function customExceptionHandler($exception): void
{
    while (ob_get_level()) {
        ob_end_clean(); // Löscht ALLES, was vorher ausgegeben wurde
    }

    header("Content-Type: text/html; charset=UTF-8");
    http_response_code(500); // Setzt den Statuscode auf "Internal Server Error"

    error_log($exception);

    $details = $exception->getMessage();
    include 'error-fenster.php';
    die;
}

// Setze die Fehler- und Ausnahmehandler
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");