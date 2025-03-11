<?php

namespace App\datenbank\Entitaeten;

use Doctrine\ORM\Mapping as ORM;
use App\datenbank\Repositories\BildRepository;

#[ORM\Entity(repositoryClass: BildRepository::class)]
#[ORM\Table(name: 'bild')]
class Bild
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: 'blob')]
    private $bild;

    private string|false|null $cachedBild = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBild(): false|string
    {
        if ($this->cachedBild !== null) {
            return $this->cachedBild;
        }

        if (is_resource($this->bild)) {
            $this->cachedBild = base64_encode(stream_get_contents($this->bild));
            return $this->cachedBild;
        }

        return $this->cachedBild = base64_encode($this->bild);
    }

    public function setBild($bild): void
    {
        $this->bild = $bild;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'bild' => $this->getBild()
        ];
    }
}