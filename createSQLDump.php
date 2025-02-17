<?php

use datenbank\EntityManagerFactory;

require_once __DIR__ . '/vendor/autoload.php';

EntityManagerFactory::dumpSchemaToSQL(true);
EntityManagerFactory::dumpSchemaToSQL(false);

echo "Prozess abgeschlossen...\n";