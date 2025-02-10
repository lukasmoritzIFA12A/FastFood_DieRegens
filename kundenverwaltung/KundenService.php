<?php

class KundenService
{
    private DatenbankAccess $datenbank;
    private mysqli $connection;

    private \Repositories\KundeRepository $kundeRepository;
    public function __construct(mysqli $connection)
    {
        $this->datenbank = new DatenbankAccess();
        $this->connection = $this->datenbank->getConnection();
        $this->kundeRepository = new \Repositories\KundeRepository($this->connection);
    }


    /**
     * Registriert einen neuen Kunden
     *
     * @param string $vorname
     * @param string $nachname
     * @param string $nutzername
     * @param string $plz
     * @param string $stadt
     * @param string $strasse
     * @param string $hsnr
     * @param string $passwort
     * @param string|null $telefonnummer Optional
     * @return bool|string Gibt `true` zurück, wenn die Registrierung erfolgreich war, oder eine Fehlermeldung bei einem Fehler.
     */
    public function registriereKunde(
        string $vorname,
        string $nachname,
        string $nutzername,
        string $plz,
        string $stadt,
        string $strasse,
        string $hsnr,
        string $passwort,
        ?string $telefonnummer = null
    ) {
        // Validierung der Eingabedaten
        if (empty($vorname) || empty($nachname) || empty($nutzername) || empty($plz) ||
            empty($stadt) || empty($strasse) || empty($hsnr) || empty($passwort)) {
            return "Bitte füllen Sie alle Pflichtfelder aus.";
        }

        // Beispielprüfung: Ist der Benutzername schon registriert?
        if ($this->istNutzernameBereitsRegistriert($nutzername)) {
            return "Der Benutzername wird bereits verwendet.";
        }

        // Überprüfung, ob die Postleitzahl genau 5 Zeichen lang ist
        if (strlen($plz) !== 5) {
            return "Bitte gib eine gültige Postleitzahl ein";
        }

        // Passwort-Hash generieren
        $passwortHash = password_hash($passwort, PASSWORD_BCRYPT);

        // Kunde in Datenbank speichern
        $erfolgreich = $this->speichereKundeInDatenbank([
            'vorname' => $vorname,
            'nachname' => $nachname,
            'nutzername' => $nutzername,
            'plz' => $plz,
            'stadt' => $stadt,
            'strasse' => $strasse,
            'hsnr' => $hsnr,
            'passwort' => $passwortHash,
            'telefonnummer' => $telefonnummer,
        ]);

        if ($erfolgreich) {
            return true;
        } else {
            return "Ein Fehler ist beim Speichern des Kunden aufgetreten.";
        }
    }

    /**
     * Prüft, ob ein Benutzername bereits registriert ist.
     *
     * @param string $nutzername
     * @return bool
     */
    private function istNutzernameBereitsRegistriert(string $nutzername): bool
    {
        return Datenbank::table('kunden')->where('nutzername', $nutzername)->exists();
    }

    /**
     * Speichert Kundendaten in der Datenbank und erstellt ein Kunde-Objekt basierend auf den gespeicherten Daten.
     *
     * @param array $kundendaten Ein assoziatives Array mit Kundendaten, einschließlich vorname, nachname, nutzername, plz, stadt, strasse, hsnr und telefonnummer.
     * @return bool|Kunde Gibt ein Kunde-Objekt zurück, wenn der Eintrag erfolgreich ist. Gibt false zurück, wenn der Eintrag fehlschlägt.
     */
    private function speichereKundeInDatenbank(array $kundendaten): bool
    {
        $insertedId = Datenbank::table('kunden')->insertGetId($kundendaten);

        if ($insertedId) {
            return new Kunde($insertedId, $kundendaten['vorname'], $kundendaten['nachname'], $kundendaten['nutzername'], $kundendaten['plz'], $kundendaten['stadt'], $kundendaten['strasse'], $kundendaten['hsnr'], $kundendaten['telefonnummer']);
        } else {
            return false;
        }
    }
}