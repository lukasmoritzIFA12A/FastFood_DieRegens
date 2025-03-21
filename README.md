Hallo

## Konfigurationen

Um das Projekt korrekt über Apache laufen zu lassen, muss es unter `xampp/htdocs` liegen.
Dazu muss das Projekt per Git in dieses Verzeichnis geklont werden.

In MySQL MUSS **max_allowed_packet** unbedingt erhöht werden damit die Contest Bilder richtig gespeichert werden können.
Dies ist notwendig da Bilder, die über eine Kamera erstellt wurden, im Durchschnitt größer als der Standard Wert sind.
Gehe dazu unter `xampp/mysql/bin/my.ini`. Dort einfach den Wert von `max_allowed_packet` auf `10M` erhöhen.

Composer wird für dieses Projekt benötigt, installiere es bitte unter https://getcomposer.org/download/.

Composer Install muss in diesem Projekt ausgeführt werden, um alle Abhängigkeiten zu installieren.
Außerdem sollte `composer dump-autoload` am Anfang einmal ausgeführt werden in der Konsole.

## Datenbankschema

Um das Datenbankschema aufzubauen, einfach folgenden Befehl im Projekt ausführen:
`php .\createSQLDump.php`
Dies erstellt zwei SQL Schema Dateien für die beiden Datenbanken: `fastfood` & `fastfoodtest`.
Die Testdatenbank wird für die SQL Unit-Tests genutzt.

Um die SQL Schemas auszuführen, einfach in der MySQL Konsole folgendes ausführen:
`mysql -u root < [PFAD_ZUM_SQL]`

Daraufhin können Testdaten für das Programm erstellt werden:
`php .\createSampleData.php`
Dies dropped ALLE Daten in der Datenbank `fastfood`. 
Dann werden folgende Testdaten erstellt:
- Zahlungsarten
- Zutaten
- Rabatte
- Menüs mit deren Produkten
- Bestellstatus
- 1 Admin Login
- 1 Nutzer