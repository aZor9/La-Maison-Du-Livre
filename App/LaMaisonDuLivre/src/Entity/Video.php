<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'video')]
#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Column]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    private ?int $IdDocument = null;

    #[ORM\Column(nullable: true)]
    private ?int $Duree = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Format = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Realisateur = null;

    public function getIddocument(): ?int
    {
        return $this->IdDocument;
    }

    public function setIddocument(int $IdDocument): static
    {
        $this->IdDocument = $IdDocument;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(?int $Duree): static
    {
        $this->Duree = $Duree;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->Format;
    }

    public function setFormat(?string $Format): static
    {
        $this->Format = $Format;

        return $this;
    }

    public function getRealisateur(): ?string
    {
        return $this->Realisateur;
    }

    public function setRealisateur(?string $Realisateur): static
    {
        $this->Realisateur = $Realisateur;

        return $this;
    }
}
