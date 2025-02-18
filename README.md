Hallo

## Konfigurationen

Um das Projekt korrekt über Apache laufen zu lassen, muss es unter `xampp/htdocs` liegen. Dafür es einfach per Git dort hinein klonen.

In MySQL MUSS **max_allowed_packet** unbedingt erhöht werden damit die Contest Bilder richtig gespeichert werden können.
Gehe dazu unter `xampp/mysql/bin/my.ini`. Dort einfach den Wert von `max_allowed_packet` auf `10M` erhöhen.

Composer Install muss in diesem Projekt ausgeführt werden, um alle Abhängigkeiten zu installieren.

## Datenbankschema

Um das Datenbankschema aufzubauen, einfach folgenden Befehl im Projekt ausführen:
`php .\createSQLDump.php`
Dies erstellt 2 SQL Schema Dateien für die beiden Datenbanken: `fastfood` & `fastfoodtest`. 
Die Testdatenbank wird für die SQL Unit-Tests genutzt.

Um die SQL Schemas auszuführen, einfach in der MySQL Konsole folgendes ausführen:
`mysql -u root < [PFAD_ZUM_SQL]`

## Datenbank Zugriff

Um im Projekt auf die Datenbank zuzugreifen, muss folgendes gemacht werden:
```php
/**
* Beispiel für die Tabelle `Adresse`
 */

$entityManager = EntityManagerFactory::createEntityManager();
$adresseRepository = new AdresseRepository($entityManager);

/**
* CRUD Operationen (Create, Read, Update, Delete)
 */

//Create & Update (Nutzt die selbe Funktion)
$adresse = new Adresse();
$adresse->setStrassenname("Teststr.");

$adresseRepository->save($adresse);

//Read
$adresse = $adresseRepository->getById(1);

//Delete
$adresseRepository->deleteById(1);

/**
* Eigene SQL Abfragen für komplexere Abfragen
 * Diese einfach in das gewollte Repository (bsp. AdresseRepository) schreiben
 */

$queryBuilder = $adresseRepository->createQueryBuilder("a"); //A ist das Alias

$name = "Gesuchte Str."

$query = $queryBuilder
    ->where('a.Strassenname = :name')
    ->setParameter('name', $name)
    ->getQuery();

$adresse = $query->getOneOrNullResult();
```

