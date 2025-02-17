Hallo

Um das Projekt korrekt über Apache laufen zu lassen, muss es unter `xampp/htdocs` liegen. Dafür es einfach per Git dort hinein klonen.

In MySQL MUSS **max_allowed_packet** unbedingt erhöht werden damit die Contest Bilder richtig gespeichert werden können.
Gehe dazu unter `xampp/mysql/bin/my.ini`. Dort einfach den Wert von `max_allowed_packet` auf `10M` erhöhen.

Composer Install muss in diesem Projekt ausgeführt werden, um alle Abhängigkeiten zu installieren.

Um das Datenbankschema aufzubauen, einfach folgenden Befehl im Projekt ausführen:
`php .\createSQLDump.php`
Dies erstellt 2 Datenbanken: `fastfood` & `fastfoodtest`. 
Die Testdatenbank wird für die SQL Unit-Tests genutzt.