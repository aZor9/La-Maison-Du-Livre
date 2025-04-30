<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Table(name: 'video')]
#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video extends Document
{
    #[ORM\Column(nullable: true)]
    private ?int $Duree = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Format = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Realisateur = null;

    public function getid_document(): ?int
    {
        return $this->id_document;
    }

    public function setid_document(int $id_document): static
    {
        $this->id_document = $id_document;

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