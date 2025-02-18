<?php

namespace App\datenbank\Entitaeten;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\BestellungRepository;

#[ORM\Entity(repositoryClass: BestellungRepository::class)]
#[ORM\Table(name: 'bestellung')]
class Bestellung
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'datetime')]
    private DateTime $BestellungDatum;

    #[ORM\ManyToOne(targetEntity: Kunde::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Kunde_id", referencedColumnName: "id")]
    private Kunde $kunde;

    #[ORM\ManyToOne(targetEntity: Zahlungsart::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Zahlungsart_id", referencedColumnName: "id")]
    private Zahlungsart $zahlungsart;

    #[ORM\ManyToOne(targetEntity: Bestellstatus::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Bestellstatus_id", referencedColumnName: "id")]
    private Bestellstatus $bestellstatus;

    #[ORM\ManyToMany(targetEntity: Menue::class, cascade: ["persist"])]
    private Collection $menues;

    #[ORM\ManyToMany(targetEntity: Produkt::class, cascade: ["persist"])]
    private Collection $produkte;

    public function __construct()
    {
        $this->menues = new ArrayCollection();
        $this->produkte = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }

    public function getBestellungDatum(): DateTime
    {
        return $this->BestellungDatum;
    }

    public function setBestellungDatum(DateTime $BestellungDatum): void
    {
        $this->BestellungDatum = $BestellungDatum;
    }

    public function getZahlungsart(): Zahlungsart
    {
        return $this->zahlungsart;
    }

    public function setZahlungsart(Zahlungsart $zahlungsart): void
    {
        $this->zahlungsart = $zahlungsart;
    }

    public function getBestellstatus(): Bestellstatus
    {
        return $this->bestellstatus;
    }

    public function setBestellstatus(Bestellstatus $bestellstatus): void
    {
        $this->bestellstatus = $bestellstatus;
    }

    public function getMenues(): Collection
    {
        return $this->menues;
    }

    public function setMenues(Collection $menues): void
    {
        $this->menues = $menues;
    }

    public function getProdukte(): Collection
    {
        return $this->produkte;
    }

    public function setProdukte(Collection $produkte): void
    {
        $this->produkte = $produkte;
    }
}