<?php

namespace Entitaeten;

use DateTime;

class Bestellung
{
    private int $idBestellung;
    private DateTime $BestellungDatum;
    private int $Kunde_idKunde;
    private int $Zahlungsart_idZahlungsart;
    private int $Produkt_idProdukt;
    private int $Menue_idMenue;
    private int $Bestellstatus_idBestellstatus;

    public function __construct(int $idBestellung, DateTime $BestellungDatum, int $Kunde_idKunde, int $Zahlungsart_idZahlungsart, int $Produkt_idProdukt, int $Menue_idMenue, int $Bestellstatus_idBestellstatus)
    {
        $this->idBestellung = $idBestellung;
        $this->BestellungDatum = $BestellungDatum;
        $this->Kunde_idKunde = $Kunde_idKunde;
        $this->Zahlungsart_idZahlungsart = $Zahlungsart_idZahlungsart;
        $this->Produkt_idProdukt = $Produkt_idProdukt;
        $this->Menue_idMenue = $Menue_idMenue;
        $this->Bestellstatus_idBestellstatus = $Bestellstatus_idBestellstatus;
    }

    public function getIdBestellung(): int
    {
        return $this->idBestellung;
    }

    public function setIdBestellung(int $idBestellung): void
    {
        $this->idBestellung = $idBestellung;
    }

    public function getBestellungDatum(): DateTime
    {
        return $this->BestellungDatum;
    }

    public function setBestellungDatum(DateTime $BestellungDatum): void
    {
        $this->BestellungDatum = $BestellungDatum;
    }

    public function getKundeIdKunde(): int
    {
        return $this->Kunde_idKunde;
    }

    public function setKundeIdKunde(int $Kunde_idKunde): void
    {
        $this->Kunde_idKunde = $Kunde_idKunde;
    }

    public function getZahlungsartIdZahlungsart(): int
    {
        return $this->Zahlungsart_idZahlungsart;
    }

    public function setZahlungsartIdZahlungsart(int $Zahlungsart_idZahlungsart): void
    {
        $this->Zahlungsart_idZahlungsart = $Zahlungsart_idZahlungsart;
    }

    public function getProduktIdProdukt(): int
    {
        return $this->Produkt_idProdukt;
    }

    public function setProduktIdProdukt(int $Produkt_idProdukt): void
    {
        $this->Produkt_idProdukt = $Produkt_idProdukt;
    }

    public function getMenueIdMenue(): int
    {
        return $this->Menue_idMenue;
    }

    public function setMenueIdMenue(int $Menue_idMenue): void
    {
        $this->Menue_idMenue = $Menue_idMenue;
    }

    public function getBestellstatusIdBestellstatus(): int
    {
        return $this->Bestellstatus_idBestellstatus;
    }

    public function setBestellstatusIdBestellstatus(int $Bestellstatus_idBestellstatus): void
    {
        $this->Bestellstatus_idBestellstatus = $Bestellstatus_idBestellstatus;
    }
}