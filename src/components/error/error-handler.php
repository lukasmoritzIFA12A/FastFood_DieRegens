<?php

function customErrorHandler($errno, $errstr, $errfile, $errline): void
{
    error_log($errstr);

    $details = $errno.":\n"."Fehler in $errfile auf Zeile $errline: $errstr";
    include 'error-fenster.php';
}

function customExceptionHandler($exception): void
{
    error_log($exception);

    $details = $exception->getMessage();
    include 'error-fenster.php';
}

// Setze die Fehler- und Ausnahmehandler
set_error_handler("customErrorHandler");
set_exception_handler("customExceptionHandler");