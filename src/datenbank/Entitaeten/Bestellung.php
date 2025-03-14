<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\BestellungRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    #[ORM\JoinColumn(name: "Bestellstatus_id", referencedColumnName: "id", nullable: true)]
    private ?Bestellstatus $bestellstatus;

    #[ORM\OneToMany(targetEntity: BestellungProdukt::class, mappedBy: 'bestellung', cascade: ['persist', 'remove'])]
    private Collection $bestellungprodukte;

    #[ORM\OneToMany(targetEntity: BestellungMenue::class, mappedBy: 'bestellung', cascade: ['persist', 'remove'])]
    private Collection $bestellungmenues;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2, nullable: true)]
    private ?string $trinkgeld;

    #[ORM\ManyToOne(targetEntity: Rabatt::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Rabatt_id", referencedColumnName: "id", nullable: true)]
    private ?Rabatt $rabatt;

    public function __construct()
    {
        $this->bestellungprodukte = new ArrayCollection();
        $this->bestellungmenues = new ArrayCollection();
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

    public function getBestellungDatum(): string
    {
        return $this->BestellungDatum->format("d.m.Y - H:i");
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

    public function getBestellstatus(): ?Bestellstatus
    {
        return $this->bestellstatus;
    }

    public function setBestellstatus(?Bestellstatus $bestellstatus): void
    {
        $this->bestellstatus = $bestellstatus;
    }

    public function getBestellungprodukte(): Collection
    {
        return $this->bestellungprodukte;
    }

    public function setBestellungprodukte(Collection $bestellungprodukte): void
    {
        $this->bestellungprodukte = $bestellungprodukte;
    }

    public function getBestellungmenues(): Collection
    {
        return $this->bestellungmenues;
    }

    public function setBestellungmenues(Collection $bestellungmenues): void
    {
        $this->bestellungmenues = $bestellungmenues;
    }

    public function getTrinkgeld(): ?string
    {
        return $this->trinkgeld;
    }

    public function setTrinkgeld(?string $trinkgeld): void
    {
        $this->trinkgeld = $trinkgeld;
    }

    public function getRabatt(): ?Rabatt
    {
        return $this->rabatt;
    }

    public function setRabatt(?Rabatt $rabatt): void
    {
        $this->rabatt = $rabatt;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'BestellungDatum' => $this->getBestellungDatum(),
            'kunde' => $this->getKunde()->jsonSerialize(),
            'zahlungsart' => $this->getZahlungsart()->jsonSerialize(),
            'bestellstatus' => $this->getBestellstatus()?->jsonSerialize(),
            'menues' => $this->getBestellungmenues()->map(fn($c) => $c->jsonSerialize())->toArray(),
            'produkte' => $this->getBestellungprodukte()->map(fn($c) => $c->jsonSerialize())->toArray(),
            'trinkgeld' => $this->getTrinkgeld(),
            'rabatt' => $this->getRabatt()?->jsonSerialize()
        ];
    }
}