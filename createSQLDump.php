<?php

use datenbank\EntityManagerFactory;

require_once __DIR__ . '/vendor/autoload.php';

try
{
    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });

    EntityManagerFactory::dumpSchemaToSQL(true);
    EntityManagerFactory::dumpSchemaToSQL(false);
}
catch (ErrorException $e)
{
    echo "Fehler: " . $e->getMessage();
    exit();
}
finally
{
    restore_error_handler();
}

echo "Prozess abgeschlossen...\n";