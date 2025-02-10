<?php


use PHPUnit\Framework\TestCase;
class KundenServiceTest extends TestCase
{
   private DatenbankAccess $datenbankAccess;
    private mysqli $conn;

    protected function setUp(): void{
        $this -> datenbankAccess = new DatenbankAccess();
        $this->conn = $this -> datenbankAccess->getConnection();
    }

    /**
     * Testet die erfolgreiche Speicherung eines Kunden in der Datenbank.
     */
    public function testSpeichereKundeInDatenbankSuccess()
    {
        $kundendaten = [
            'vorname' => 'Max',
            'nachname' => 'Mustermann',
            'nutzername' => 'maxmustermann',
            'plz' => '12345',
            'stadt' => 'Musterstadt',
            'strasse' => 'Musterstraße',
            'hsnr' => '1',
            'passwort' => password_hash('passwort123', PASSWORD_BCRYPT),
            'telefonnummer' => '123456789',
        ];

        $mockDatenbank = $this->createMock(KundeRepository($this->conn)::class);
        $mockDatenbank->expects($this->once())
            ->method('insertGetId')
            ->with($this->equalTo($kundendaten))
            ->willReturn(1);

        KundeRepository($this->conn)::setInstance($mockDatenbank);

        $kundenService = new KundenService();
        $result = $kundenService->registriereKunde(
            $kundendaten['vorname'],
            $kundendaten['nachname'],
            $kundendaten['nutzername'],
            $kundendaten['plz'],
            $kundendaten['stadt'],
            $kundendaten['strasse'],
            $kundendaten['hsnr'],
            'passwort123',
            $kundendaten['telefonnummer']
        );

        $this->assertTrue($result);
    }

    /**
     * Testet das Fehlschlagen der Speicherung eines Kunden in der Datenbank.
     */
    public function testSpeichereKundeInDatenbankFailure()
    {
        $kundendaten = [
            'vorname' => 'Max',
            'nachname' => 'Mustermann',
            'nutzername' => 'maxmustermann',
            'plz' => '12345',
            'stadt' => 'Musterstadt',
            'strasse' => 'Musterstraße',
            'hsnr' => '1',
            'passwort' => password_hash('passwort123', PASSWORD_BCRYPT),
            'telefonnummer' => null,
        ];

        $mockDatenbank = $this->createMock(KundeRepository($this->conn)::class);
        $mockDatenbank->expects($this->once())
            ->method('insertGetId')
            ->with($this->equalTo($kundendaten))
            ->willReturn(false);

        Datenbank::setInstance($mockDatenbank);

        $kundenService = new KundenService();
        $result = $kundenService->registriereKunde(
            $kundendaten['vorname'],
            $kundendaten['nachname'],
            $kundendaten['nutzername'],
            $kundendaten['plz'],
            $kundendaten['stadt'],
            $kundendaten['strasse'],
            $kundendaten['hsnr'],
            'passwort123'
        );

        $this->assertEquals("Ein Fehler ist beim Speichern des Kunden aufgetreten.", $result);
    }

    /**
     * Testet die Speicherung eines Kunden mit ungültigen Daten in der Datenbank.
     */
    public function testSpeichereKundeInDatenbankInvalidData()
    {
        $kundenService = new KundenService();
        $result = $kundenService->registriereKunde(
            '', // vorname leer
            'Mustermann',
            'maxmustermann',
            '1234', // Ungültige PLZ
            'Musterstadt',
            'Musterstraße',
            '1',
            'passwort123'
        );

        $this->assertEquals("Bitte gib eine gültige Postleitzahl ein", $result);
    }
}
