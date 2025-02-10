<?php
class Kunde
{
    private string $vorname;
    private string $nachname;
    private string $nutzername;
    private string $plz;
    private string $stadt;
    private string $strasse;
    private string $hsnr;
    private string $passwort;
    private ?string $telefonnummer;

    /**
     * Konstruktor für das Kunde-Objekt
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
     */
    public function __construct(
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
        $this->vorname = $vorname;
        $this->nachname = $nachname;
        $this->nutzername = $nutzername;
        $this->plz = $plz;
        $this->stadt = $stadt;
        $this->strasse = $strasse;
        $this->hsnr = $hsnr;
        $this->passwort = $passwort;
        $this->telefonnummer = $telefonnummer;
    }

    // Getter-Methoden
    public function getVorname(): string
    {
        return $this->vorname;
    }

    public function getNachname(): string
    {
        return $this->nachname;
    }

    public function getNutzername(): string
    {
        return $this->nutzername;
    }

    public function getPlz(): string
    {
        return $this->plz;
    }

    public function getStadt(): string
    {
        return $this->stadt;
    }

    public function getStrasse(): string
    {
        return $this->strasse;
    }

    public function getHsnr(): string
    {
        return $this->hsnr;
    }

    public function getPasswort(): string
    {
        return $this->passwort;
    }

    public function getTelefonnummer(): ?string
    {
        return $this->telefonnummer;
    }
}