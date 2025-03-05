<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function customErrorHandler($errno, $errstr, $errfile, $errline): void
{
    error_log($errstr);

    $details = $errno.":\n"."Fehler in $errfile auf Zeile $errline: $errstr";
    include 'error-fenster.php';
    die;
}

#[NoReturn] function customExceptionHandler($exception): void
{
    error_log($exception);

    $details = $exception->getMessage();
    include 'error-fenster.php';
    die;
}

// Setze die Fehler- und Ausnahmehandler
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");