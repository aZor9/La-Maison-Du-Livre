<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Table(name: 'livre')]
#[ORM\UniqueConstraint(name: 'ISBN', columns: ['ISBN'])]
#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre extends Document
{
    // #[ORM\Column]
    // #[ORM\Id]
    // #[ORM\GeneratedValue(strategy: "NONE")]
    // private ?int $id_document = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ISBN = null;

    #[ORM\Column(nullable: true)]
    private ?int $NombrePage = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Genre = null;

    public function getid_document(): ?int
    {
        return $this->id_document;
    }

    public function setid_document(int $id_document): static
    {
        $this->id_document = $id_document;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->ISBN;
    }

    public function setIsbn(?string $ISBN): static
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getNombrepage(): ?int
    {
        return $this->NombrePage;
    }

    public function setNombrepage(?int $NombrePage): static
    {
        $this->NombrePage = $NombrePage;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->Genre;
    }

    public function setGenre(?string $Genre): static
    {
        $this->Genre = $Genre;

        return $this;
    }
}
