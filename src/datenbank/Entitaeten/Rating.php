<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\RatingRepository;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ORM\Table(name: 'rating')]
class Rating
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Kunde::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Kunde_id", referencedColumnName: "id")]
    private Kunde $kunde;

    #[ORM\ManyToOne(targetEntity: Contest::class, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "Contest_id", referencedColumnName: "id")]
    private Contest $contest;

    #[ORM\Column(type: 'integer', length: 5)]
    private int $Rating;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRating(): int
    {
        return $this->Rating;
    }

    public function setRating(int $Rating): void
    {
        $this->Rating = $Rating;
    }

    public function getContest(): Contest
    {
        return $this->contest;
    }

    public function setContest(Contest $contest): void
    {
        $this->contest = $contest;
    }

    public function getKunde(): Kunde
    {
        return $this->kunde;
    }

    public function setKunde(Kunde $kunde): void
    {
        $this->kunde = $kunde;
    }
}