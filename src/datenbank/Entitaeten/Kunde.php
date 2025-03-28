<?php

namespace App\datenbank\Entitaeten;

use App\datenbank\Repositories\KundeRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KundeRepository::class)]
#[ORM\Table(name: 'kunde')]
class Kunde
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Adresse::class, cascade: ["remove", "persist"])]
    #[ORM\JoinColumn(name: "Adresse_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Adresse $adresse;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Vorname;

    #[ORM\Column(type: 'string', length: 255)]
    private string $Nachname;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $Telefonnummer;

    #[ORM\Column(type: 'datetime')]
    private DateTime $Registrierungsdatum;

    #[ORM\ManyToOne(targetEntity: Login::class, cascade: ["remove", "persist"])]
    #[ORM\JoinColumn(name: "Login_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Login $login;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAdresse(): Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(Adresse $adresse): void
    {
        $this->adresse = $adresse;
    }

    public function getVorname(): string
    {
        return $this->Vorname;
    }

    public function setVorname(string $Vorname): void
    {
        $this->Vorname = $Vorname;
    }

    public function getNachname(): string
    {
        return $this->Nachname;
    }

    public function setNachname(string $Nachname): void
    {
        $this->Nachname = $Nachname;
    }

    public function getTelefonnummer(): ?string
    {
        return $this->Telefonnummer;
    }

    public function setTelefonnummer(?string $Telefonnummer): void
    {
        $this->Telefonnummer = $Telefonnummer;
    }

    public function getRegistrierungsdatum(): string
    {
        return $this->Registrierungsdatum->format("d.m.Y");
    }

    public function setRegistrierungsdatum(DateTime $Registrierungsdatum): void
    {
        $this->Registrierungsdatum = $Registrierungsdatum;
    }

    public function getLogin(): Login
    {
        return $this->login;
    }

    public function setLogin(Login $login): void
    {
        $this->login = $login;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'adresse' => $this->getAdresse()->jsonSerialize(),
            'Vorname' => $this->getVorname(),
            'Nachname' => $this->getNachname(),
            'Telefonnummer' => $this->getTelefonnummer(),
            'Registrierungsdatum' => $this->getRegistrierungsdatum(),
            'login' => $this->getLogin()->jsonSerialize()
        ];
    }
}