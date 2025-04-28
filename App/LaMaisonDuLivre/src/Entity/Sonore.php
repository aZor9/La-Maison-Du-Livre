<?php

namespace App\Entity;

use App\Repository\SonoreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Table(name: 'sonore')]
#[ORM\Entity(repositoryClass: SonoreRepository::class)]
class Sonore extends Document
{
    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $id_document = null;

    #[ORM\Column(nullable: true)]
    private ?int $Duree = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Format = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Interprete = null;

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

    public function getInterprete(): ?string
    {
        return $this->Interprete;
    }

    public function setInterprete(?string $Interprete): static
    {
        $this->Interprete = $Interprete;

        return $this;
    }
}
